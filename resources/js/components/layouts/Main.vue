<template>
    <el-container>
        <el-header>
            <el-menu
                :default-active="menuIndex"
                mode="horizontal"
            >
                <el-menu-item index="0" @click="$router.push('/')">DIV</el-menu-item>
                <el-menu-item index="1"  @click="$router.push('/requests/create')">
                    Form
                </el-menu-item>
                <el-menu-item index="2" @click="$router.push('/requests')">
                   List
                </el-menu-item>
            </el-menu>
        </el-header>
        <el-main>
            <el-row justify="center">
                <el-col :span="18"> <router-view></router-view></el-col>
            </el-row>
        </el-main>
    </el-container>
</template>
<script>
export default {
    name:"main-layout",
    data(){
        return {
            menuIndex: '0'
        }
    }
}
</script>

