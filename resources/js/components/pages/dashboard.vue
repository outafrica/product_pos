<template>
    <div>
       <div>
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu" >
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content" v-if="user.role_id == 2">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li><router-link to="/admin/products"><Icon type="ios-cart" />Products</router-link></li>
                            <li><router-link to="/admin/expenses"><Icon type="ios-cash" />Expenses</router-link></li>
                            <li><router-link to="/admin/sales"><Icon type="ios-stats" />Sales</router-link></li>
                            <!-- <li><router-link to="/admin/users"><Icon type="ios-people" />Users</router-link></li> -->
                            <!-- <li><router-link to="/admin/roles"><Icon type="md-key" />Roles</router-link></li> -->

                        </ul>
                    </div>
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content" v-else>
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Agent</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li><router-link to="/agent/products"><Icon type="ios-cart" />Products</router-link></li>
                            <li><router-link to="/agent/expenses"><Icon type="ios-cash" />Expenses</router-link></li>
                            <li><router-link to="/agent/sales"><Icon type="ios-stats" />Sales</router-link></li>

                        </ul>
                    </div>
                </div>

            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                        </ul>
                    </div>
                    <div class="profile">
                        <Dropdown>
                            <a href="javascript:void(0)">
                                <Icon type="ios-contact" size="24" />
                            </a>
                            <DropdownMenu slot="list">
                                <DropdownItem><router-link  class="logout" to="/settings"><Icon type="ios-settings" size="24" /> Settings</router-link></DropdownItem>
                                <DropdownItem><a  class="logout" href="/logout"><Icon type="ios-log-out" size="24" /> Logout </a></DropdownItem>
                            </DropdownMenu>
                        </Dropdown>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
    	<router-view/>
    </div>
    
</template>

<script>
    export default {

        props: ['user'],            
        data(){
            return {
                isLoggedin: false,
                token: '',
            }
        },
        // methods: {
        //     async logoutUser(){
                
        //         const res = await this.callApi('post', '/logout');
                
        //         if(res.status == 200){
                    
        //             window.location = '/';
                    
        //         }else{
        //             this.d();
        //         }

        //     },
        // },
        // async created() {

        //     this.token = window.Laravel.csrfToken;
		// },
        
    }
</script>

<style>
    .profile{
        padding-left: 90%;
    }
    .logout{
        color: black;
    }
</style>