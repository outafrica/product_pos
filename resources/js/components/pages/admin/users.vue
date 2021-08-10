<template>
   <div>
		<div class="content">
			<div class="container-fluid">
					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users <Button @click="addUserModal=true"><Icon type="md-add"/> Add User</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, t) in users " :key="t" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.full_name}}</td>
								<td>{{user.email}}</td>
								<td>{{user.role_id}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(user, t)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(user, t)" :loading="user.isDeleting">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
					<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

					<!--~~~~~~~ Begining of user addition modal ~~~~~~~~~-->

					 <Modal
						v-model="addUserModal"
						title="Add User"
						:mask-closable="false"
						:closable="false"
						>

						<div style="padding: 10px 0">

							<Input type="text" v-model="data.full_name" placeholder="Full Name..." />

						</div>
						<div style="padding: 10px 0">

							<Input type="email" v-model="data.email" placeholder="Email..." />
							
						</div>
						<div style="padding: 10px 0">

							<Input type="password" v-model="data.password" placeholder="Password..." />
							
						</div>						
						<div style="padding: 10px 0">

							<Select v-model="data.role_id" placeholder="Select user role">
								<Option v-for="(role, r) in roles" :key="r" :value="role.id">{{ role.name }}</Option>
							</Select>

						</div>						


						<div slot="footer">
							<Button type="success" @click="addUser" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add User'}}</Button>
							<Button type="error" @click="addUserModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of user addition modal ~~~~~~~~~-->


					<!--~~~~~~~ Begining of user editing modal ~~~~~~~~~-->

					 <Modal
						v-model="editUserModal"
						title="Edit user"
						:mask-closable="false"
						:closable="false"
						>
						<div style="padding: 10px 0">

							<Input type="text" v-model="editData.full_name" placeholder="Full Name..." />

						</div>
						<div style="padding: 10px 0">

							<Input type="email" v-model="editData.email" placeholder="Email..." />
							
						</div>
						<div style="padding: 10px 0">

							<Input type="password" v-model="editData.password" placeholder="Password..." />
							
						</div>						
						<div style="padding: 10px 0">

							 <Select v-model="editData.role_id" placeholder="Select user role">
								<Option v-for="(role, r) in roles" :key="r" :value="role.id">{{ role.name }}</Option>
							</Select>														
						</div>						

						<div slot="footer">
							<Button type="success" @click="editUser" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing...' : 'Submit'}}</Button>
							<Button type="error" @click="editUserModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of User editing modal ~~~~~~~~~-->

					<!--~~~~~~~ Begining of category delete modal ~~~~~~~~~-->
					
					<!-- <deleteModal></deleteModal> -->

					<!--~~~~~~~ End of category delete modal ~~~~~~~~~-->


				</div>
			</div>
		</div>
	</div>
</template>

<script>
    // import deleteModal from './modals/delete.vue'
    export default {
		data () {
           return {

				data: {

					full_name: '',
					email: '',
					password: '',
					role_id: null,

				},
				addUserModal: false,
				isAdding: false,
				users: [],
				editUserModal: false,
				isEditing: false,
				editData: {

					full_name: '',
					email: '',
					password: '',
					role_id: null,

				},
				index: -1,
				deleteUserModal: false,
				deleteData: {

					full_name: '',
					email: '',
					password: '',
					role_id: null,

				},
				modal_loading: false,
				roles: [],

			}
       },
       methods: {
		   async addUser(){
			   
				if(this.data.full_name.trim() == ''){
				   return this.e('The Full Name is required');
				}else if(this.data.email.trim() == ''){
				   return this.e('The Email is required');
				}else if(this.data.password.trim() == ''){
				   return this.e('The Password is required');
				}else if(!this.data.role_id){
				   return this.e('The User Type is required');
				}


				const res = await this.callApi('post', '/admin/users/create_user', this.data);
				if(res.status == 201){
					
					this.users.unshift(res.data);
					this.s('User successfully added');
					this.addUserModal=false;
					this.data.full_name ='';
					this.data.email ='';
					this.data.password ='';
					this.data.role_id = null;


				}else{
					
					if(res.status == 422){
						
						for(let i in res.data.errors){
							this.e(res.data.errors[i][0])
						}

						// if(res.data.errors.full_name){
						// 	this.e(res.data.errors.full_name[0])
						// }else if(res.data.errors.email){
						// 	this.e(res.data.errors.email[0])
						// }else if(res.data.errors.password){
						// 	this.e(res.data.errors.password[0])
						// }else if(res.data.errors.role_id){
						// 	this.e(res.data.errors.role_id[0])
						// }

					}else{					
						this.d();
					}					

				}

			},
			showEditModal(user, index){
				let obj = {
					id: user.id,
					full_name: user.full_name,
					email: user.email,
					role_id: user.role_id,
				}
				this.editData = obj;
				this.editUserModal = true;
				this.index = index;
			},
		    async editUser(){
			   
			   if(this.editData.full_name.trim() == ''){
				   return this.e('The Full Name is required');
				}else if(this.editData.email.trim() == ''){
				   return this.e('The Email is required');
				}else if(!this.editData.role_id){
				   return this.e('The User Type is required');
				}
			   const res = await this.callApi('post', '/admin/users/edit_user', this.editData);
				if(res.status == 200){
					this.users[this.index] = this.editData;
					this.s('User successfully edited');
					this.editUserModal=false;

				}else{
					
					if(res.status == 422){

						for(let i in res.data.errors){
							this.e(res.data.errors[i][0])
						}

						// if(res.data.errors.full_name){
						// 	this.e(res.data.errors.full_name[0])
						// }else if(res.data.errors.email){
						// 	this.e(res.data.errors.email[0])
						// }else if(res.data.errors.password){
						// 	this.e(res.data.errors.password[0])
						// }else if(res.data.errors.role_id){
						// 	this.e(res.data.errors.role_id[0])
						// }

					}else{					
						this.d();
					}					

				}

			},
			showDeleteModal(user, index){
			
			const deleteModalObj = {

					showDeleteModal: true,
					deleteUrl: '/admin/users/delete_user',
					data: user,
					index: index,
					isDeleted: false,

				}
				
				this.index = index;
				this.$store.commit('setDeleteModalObj', deleteModalObj);

				console.log('Method called', index);


			},

		},
		async created() {
			const [res, resRoles] = await Promise.all([

				this.callApi('get', '/admin/users/all_users'),
				this.callApi('get', '/admin/roles/all_roles')

			])
			
			if(res.status == 200){
				this.users = res.data;
			}else{
				this.d();
			}

			if(resRoles.status == 200){
				this.roles = resRoles.data;
			}else{
				this.d();
			}

		},
		// components: {
		// 	deleteModal,
		// },
		// computed: {
		// 	...mapGetters({

		// 		'deletedObj' : 'getDeleteModal',
		// 	})

		// },
		// watch: {

		// 	deletedObj(obj){

		// 		console.log(obj);

		// 		if(obj.isDeleted){

		// 			this.users.splice(this.index, 1);

		// 		}

		// 	},

		// },
    }
</script>
