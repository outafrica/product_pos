<template>
    <div class="container">
        <!-- Login form -->
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">

            <div class="login_header">
                <h1>Login</h1>
            </div>

            <div style="padding: 10px 0">

                <Input type="email" v-model="loginData.email" placeholder="Email..." />
                
            </div>
            <div style="padding: 10px 0">

                <Input type="password" v-model="loginData.password" placeholder="****" />
                
            </div>

            <div class="login_footer">

                <Button type="success" @click="login" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Logging ...' : 'Login'}}</Button>

            </div>

        
        </div>
    </div>
</template>

<script>
    export default {
       data(){
            
        return {

            loginData: {
                
                email: '',
                password: '',

            },

            isLogging: false,
            token: '',

        }

       },

       methods: {
           async login(){

               this.token = window.Laravel.csrfToken;

               	if(this.loginData.email.trim() == ''){
				   return this.e('The Email is required');
				}else if(this.loginData.password.trim() == ''){
				   return this.e('The Password is required');
				}

                const res = await this.callApi('post', '/login', this.loginData);
				if(res.status == 200){

					this.s('Successfully looged in!');

                    if(res.data.msg == 'User'){

                        window.location = '/agent';

                    }else{

                        window.location = '/admin';

                    }


				}else{
					
					if(res.status == 401){
						
                        this.i(res.data.msg)

					}else if(res.status == 422){
						
						for(let i in res.data.errors){
							this.e(res.data.errors[i][0])
						}

					}else{					
						this.d();
					}					

				}
           }
       },
    }
</script>

<style scoped>

    ._1adminOverveiw_table_recent {

        margin: 0 auto;
        margin-top: 20%;

    }
    .login_footer {

        text-align: center;
    
    }
    .login_header {

        text-align: center;
    
    }

</style>
