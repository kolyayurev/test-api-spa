<template>
    <h1>Add request</h1>
    <el-form
        :model="model"
        :rules="rules"
        ref="form"
        label-position="top">
        <el-row :gutter="30">
            <el-col>
                <el-form-item label="Name" prop="name" :error="errors.name">
                    <el-input v-model="model.name" maxlength="255"></el-input>
                </el-form-item>
                <el-form-item label="Email" prop="email" :error="errors.email">
                    <el-input v-model="model.email" maxlength="255"></el-input>
                </el-form-item>
                <el-form-item label="Message" prop="message" :error="errors.message">
                    <el-input :rows="2"
                              type="textarea"
                              v-model="model.message"
                              maxlength="1024">
                    </el-input>
                </el-form-item>
            </el-col>
            <el-col>
                <el-button @click="submit" type="primary">
                    Submit
                </el-button>
            </el-col>
        </el-row>
    </el-form>
</template>
<script>
import {mapActions} from 'vuex'
import {ElNotification} from 'element-plus'

export default {
    name: "dashboard",
    data() {
        return {
            model: {
                name: null,
                email: null,
                message: null,
            },
            errors:{
                name: null,
                email: null,
                message: null,
            },
            rules: {
                email: [
                    {required: true, message: 'Required field', trigger: 'change'},
                    {type: 'email', message: 'Must be email', trigger: 'change'},
                    {
                        max: 255,
                        message: 'Limit overflow',
                        trigger: 'change'
                    }
                ],
                name: [
                    {required: true, message: 'Required field', trigger: 'change'},
                    {
                        max: 255,
                        message: 'Limit overflow',
                        trigger: 'change'
                    }
                ],
                message: [
                    {required: true, message: 'Required field', trigger: 'change'},
                    {
                        max: 1024,
                        message: 'Limit overflow',
                        trigger: 'change'
                    }
                ],
            }
        }
    },
    methods: {
        ...mapActions({
            storeRequests: "requests/store"
        }),
        async submit() {
            let _this = this;

            _this.$refs.form.validate((valid) => {
                if (valid) {
                    _this.storeRequests(this.model).then((response) => {
                        const status = response.data.status;
                        console.log(status)
                        switch (status) {
                            case 'success':
                                ElNotification({
                                    title: 'Success',
                                    message: 'Success add request',
                                    type: 'success',
                                })
                                _this.clearForm();
                                _this.$refs.form.reset();
                                break;
                            case 'validation':
                                _this.setErrors(response.data.errors);
                                break;
                            case 'error':
                                ElNotification({
                                    title: 'Error',
                                    message:  response.data.message,
                                    type: 'error',
                                });
                                break;
                        }

                    });

                } else {
                    return false
                }
            });
        },
        clearForm() {
            this.model.name = null;
            this.model.email = null;
            this.model.message = null;
        },
        setErrors(errors){
            this.errors.name = errors.name ? errors.name[0] : null;
            this.errors.email = errors.email ? errors.email[0] : null;
            this.errors.message = errors.message ? errors.message[0] : null;
        }
    }
}
</script>
