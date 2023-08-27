<template>
    <h1>List of requests</h1>
    <el-table :data="list.data" style="width: 100%">
        <el-table-column prop="created_at" label="Date" width="250">

            <template #header>
                <el-date-picker
                    v-model="filters.created_at"
                    type="date"
                    placeholder="Date"
                    @change="onChange"
                    value-format="YYYY-MM-DD"
                />
            </template>
            <template #default="scope">
                {{ scope.row.created_at }}
            </template>
        </el-table-column>
        <el-table-column prop="name" label="Name" width="180"/>
        <el-table-column prop="email" label="Email" width="180"/>
        <el-table-column prop="message" label="message" width="auto"/>
        <el-table-column prop="status" width="150">
            <template #header>
                <el-select v-model="filters.status" placeholder="Status" clearable @change="onChange">
                    <el-option
                        v-for="status in statuses"
                        :key="status.value"
                        :label="status.label"
                        :value="status.value"

                    />
                </el-select>
            </template>
            <template #default="scope">
                <el-tag
                    :type="scope.row.status === 'active' ? '' : 'success'"
                    disable-transitions
                >{{ scope.row.status }}
                </el-tag>
            </template>
        </el-table-column>
        <el-table-column fixed="right" label="Operations" width="170">
            <template #default="scope">
                <el-button link type="primary" size="small" @click="toAnswer(scope.row.id)">Answer</el-button>
                <el-button link type="danger" size="small" @click="onDelete(scope.row.id)">Delete</el-button>
            </template>
        </el-table-column>
    </el-table>
    <el-pagination layout="prev, pager, next" :total="list.total" v-model:current-page="filters.page"
                   @current-change="onChange"/>
    <el-dialog
        v-model="openAnswerDialog"
        title="Answer"
        width="30%"
    >
        <el-form
            :model="answer"
            :rules="answerRules"
            ref="form"
            label-position="top">
            <el-row :gutter="30">
                <el-col :span="12">
                    <el-form-item label="Name">
                        <el-input v-model="item.name" disabled/>
                    </el-form-item>
                </el-col>
                <el-col :span="12">
                    <el-form-item label="Email">
                        <el-input v-model="item.email" disabled/>
                    </el-form-item>
                </el-col>
                <el-col>
                    <el-form-item label="Message">
                        <el-input v-model="item.message" type="textarea" :rows="5" disabled/>
                    </el-form-item>
                </el-col>
                <el-divider></el-divider>
                <el-col>
                    <el-form-item label="Comment" prop="comment">
                        <el-input :rows="5"
                                  type="textarea"
                                  v-model="answer.comment"
                                  maxlength="1024">
                        </el-input>
                    </el-form-item>
                </el-col>
            </el-row>
        </el-form>
        <template #footer>
      <span class="dialog-footer">
        <el-button @click="openAnswerDialog = false">Cancel</el-button>
        <el-button @click="submitAnswer" type="primary">
            Submit
        </el-button>
      </span>
        </template>
    </el-dialog>
</template>
<script>
import {mapActions} from "vuex";
import {ElNotification} from "element-plus";

export default {
    name: "requests",
    data() {
        return {
            answer: {
                comment: null,
                status: 'resolved'
            },
            answerRules: {
                comment: [
                    {required: true, message: 'Required field', trigger: 'change'},
                    {
                        max: 1024,
                        message: 'Limit overflow',
                        trigger: 'change'
                    }
                ],
            },
            filters: {
                name: null,
                email: null,
                status: null,
                created_at: null,
                page: 1
            },
            statuses: [
                {label: 'Active', value: 'active'},
                {label: 'Resolved', value: 'resolved'},
            ],
            item: {
                name: null,
                email: null,
                status: null,
                created_at: null,
            },
            openAnswerDialog: false,
        }
    },
    computed: {
        list() {
            return this.$store.state.requests.list;
        }
    },
    beforeMount() {
        this.load();
    },
    methods: {
        ...mapActions({
            listRequests: "requests/list",
            itemRequests: "requests/item",
            deleteRequests: "requests/delete",
            answerRequests: "requests/answer",
        }),
        load() {
            this.listRequests(this.filters);
        },
        onChange() {
            this.load();
        },
        onDelete(id) {
            this.deleteRequests(id).then(response => {
                this.load();
            });
        },
        toAnswer(id) {
            this.itemRequests(id).then(response => {
                this.item = response.data.data;
                this.openAnswerDialog = true;
            });
        },
        submitAnswer() {
            let _this = this;

            _this.$refs.form.validate((valid) => {
                if (valid) {
                    _this.answerRequests( { id: this.item.id, answer: this.answer }).then((response) => {
                        const status = response.data.status;
                        console.log(status)
                        switch (status) {
                            case 'success':
                                ElNotification({
                                    title: 'Success',
                                    message: 'Success add request',
                                    type: 'success',
                                })
                                this.load();
                                this.openAnswerDialog = false;
                        }

                    });
                } else {
                    return false
                }
            });
        }
    }

}
</script>
