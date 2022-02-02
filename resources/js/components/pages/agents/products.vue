<template>
   <div>
		<div class="content">
			<div class="container-fluid">
					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Products 
						<!-- <Button @click="addProductModal=true"><Icon type="md-add"/> Add Product</Button> -->
					</p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Image</th>
								<th>Type</th>
								<th>Model</th>
								<th>Quantity</th>
								<th>Price</th>
								<!-- <th>Total</th> -->
								<!-- <th>Action</th> -->
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(product, c) in products " :key="c">
								<td>{{ c + 1 }}</td>
								<td class="table_pro_img">
									<img :src="product.image" alt="" srcset="">
								</td>
								<td class="_table_name">{{product.name}}</td>
								<td>{{product.brand}} {{product.model_name}}</td>
								<td>{{product.quantity}}</td>
								<td>{{product.wholesale_price}}</td>
								<!-- <td>{{product.total}}</td> -->
								<!-- <td>
									<Button type="info" size="small" @click="showEditModal(product, c)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(product, c)" :loading="product.isDeleting">Delete</Button>
								</td> -->
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
					<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Product addition modal ~~~~~~~~~-->

					 <Modal
						v-model="addProductModal"
						title="Add Product"
						:mask-closable="false"
						:closable="false"
						>

						<Input v-model="data.name" placeholder="Product Name..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.model_name" placeholder="Product Model..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.quantity" type="number" placeholder="Quantity..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.buying_price" type="number" placeholder="Product Price..." />

                        <div style="margin: 10px;"></div>

                        <Upload
							:on-success="handleSuccess"
							:on-error="handleError"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
							ref = "uploads"
                            type="drag"
							:headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest' }"
                            action="/agent/products/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag file here to upload</p>
                            </div>
                        </Upload>

						<div class="demo-upload-list" v-if="data.image">
							<img :src="data.image" alt="" srcset="">
							 <div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage(data.image, true)"></Icon>
							</div>
						</div>
						
                        <div slot="footer">
							<Button type="success" @click="addProduct" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Product'}}</Button>
							<Button type="error" @click="addProductModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Product addition modal ~~~~~~~~~-->


					<!--~~~~~~~ Begining of Product editing modal ~~~~~~~~~-->

					 <Modal
						v-model="editProductModal"
						title="Edit Product"
						:mask-closable="false"
						:closable="false"
						>
						<Input v-model="editData.name" placeholder="Product Name..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.model_name" placeholder="Product Model..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.quantity" type="number" placeholder="Quantity..." />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.buying_price" type="number" placeholder="Product Price..." />

                        <div style="margin: 10px;"></div>

                        <Upload v-show="isUploadImage"
							:on-success="handleSuccess"
							:on-error="handleError"
							:format="['jpg','jpeg','png']"
							:max-size="2048"
							:on-format-error="handleFormatError"
							:on-exceeded-size="handleMaxSize"
							ref = "edituploads"
                            type="drag"
							:headers="{'x-csrf-token': token, 'X-Requested-With': 'XMLHttpRequest' }"
                            action="/agent/products/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag file here to upload</p>
                            </div>
                        </Upload>

						<div class="demo-upload-list" v-if="editData.image">
							<img :src="editData.image" alt="" srcset="">
							 <div class="demo-upload-list-cover">
								<Icon type="ios-trash-outline" @click="deleteImage(editData.image, false)"></Icon>
							</div>
						</div>

						<div slot="footer">
							<Button type="success" @click="editProduct" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing...' : 'Submit'}}</Button>
							<Button type="error" @click="editProductModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Product editing modal ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Product delete modal ~~~~~~~~~-->
					
					<Modal 
						v-model="deleteModal"
						width="360"
						:mask-closable="false"
						:closable="false">
						<p slot="header" style="color:#f60;text-align:center">
							<Icon type="ios-information-circle"></Icon>
							<span>Delete confirmation</span>
						</p>
						<div style="text-align:center">
							<p>Are you sure you want to delete this item?</p>
						</div>
						<div slot="footer">
							<Button type="error" size="large" :loading="modal_loading" @click="deleteAction">Delete</Button>
							<Button type="default" size="large" @click="deleteModal=false">Close</Button>

						</div>
					</Modal>

					<!--~~~~~~~ End of Product delete modal ~~~~~~~~~-->



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
					name: '',
					image: '',
                    model_name: '',
                    quantity: '',
                    buying_price: '',
				},
				addProductModal: false,
				isAdding: false,
				products: [],
				editProductModal: false,
				isEditing: false,
				editData: {
					name: '',
					image: '',
                    model_name: '',
                    quantity: '',
                    buying_price: '',
				},
				index: -1,
				deleteModal: false,
				deleteData: { },
				modal_loading: false,
				token: '',
				isUploadImage: false,
				isEditingImage: false,

			}
       },
       methods: {
			handleSuccess (res, file) {

				if(this.isEditingImage){

					this.editData.image = res;

				}
				
                this.data.image = res;

			},
			handleError (res, file) {
					
				this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: file.errors.file.length ? file.errors.file[0] : 'Something went wrong'
                });   
            
			},
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },
		   async addProduct(){
			   
				if(this.data.name.trim() == ''){
				   return this.e('The product name is required');
				}
				// else if(this.data.image.trim() == ''){
				//    return this.e('Image upload is required');
				// }
				const res = await this.callApi('post', '/agent/products/create_product', this.data);
				if(res.status == 201){

					this.products.unshift(res.data);
					this.s('Product successfully added');
					this.addProductModal=false;
					this.data.name ='';
					this.data.image ='';


				}else{
					
					if(res.status == 422){
						for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
					}else{					
						this.d();
					}					

				}

			},
			showEditModal(product, index){
				let obj = {
					id: product.id,
					name: product.name,
					image: product.image,
					model_name: product.model_name,
					quantity: product.quantity,
					buying_price: product.buying_price
				}
				this.editData = obj;
				this.editProductModal = true;
				this.index = index;
			},
		    async editProduct(){
			   
			   if(this.editData.name.trim() == ''){
				   return this.e('The product name is required');
			   }

				const res = await this.callApi('post', '/agent/products/edit_product', this.editData);
				if(res.status == 200){
					this.products[this.index].name = this.editData.name;
					this.products[this.index].image = this.editData.image;
					this.products[this.index].model_name = this.editData.model_name;
					this.products[this.index].quantity = this.editData.quantity;
					this.products[this.index].buying_price = this.editData.buying_price;
					this.products[this.index].total = this.editData.buying_price * this.editData.quantity;
					this.s('Product successfully updated');
					this.data.image = '';	
					this.editProductModal = false;
					this.isEditingImage = false;
					this.isUploadImage = false;

				}else{
					
					if(res.status == 422){
						for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
					}else{					
						this.d();
					}					

				}

			},
			showDeleteModal(product, index){
				
				this.deleteData = product;
				this.index = index;
				this.deleteModal = true;
				
			},
			async deleteImage(image, isAdd){

				this.deleteData.image = image;
			
				const res = await this.callApi('post', '/agent/products/delete_image', this.deleteData );
				if(res.status == 200){


					if(!isAdd){ //For editing

						this.isUploadImage = true;
						this.isEditingImage = true;
						this.editData.image = '';
						this.$refs.edituploads.clearFiles();
						this.$Message.success('Image successfully deleted');

					}else{

						this.data.image = '';
						this.$refs.uploads.clearFiles();
						this.$Message.success('Image successfully deleted');
						
					}

				}else{		
					
					if(res.status == 422){
						for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
					}else{					
						this.d();
					}	
									
				}

			},
			async deleteAction(){

				const res = await this.callApi('post', '/agent/products/delete_product', this.deleteData);
				if(res.status == 200){
					
					setTimeout(() => {
						this.modal_loading = false;
						this.$Message.success('Product successfully deleted');
					}, 1000);
					this.products.splice(this.index, 1);
					this.deleteModal = false;

				}else{		
					
					if(res.status == 422){
						for(let i in res.data.errors){
							this.e(res.data.errors[i][0])
                        }

					}else{
						this.modal_loading = false;
						this.d();

					}	
									
				}

			},
        },
		async created() {

			this.token = window.Laravel.csrfToken;
			const res = await this.callApi('get', '/agent/products/all_products');
			if(res.status == 200){
				this.products = res.data;
			}else{
				this.d();
			}
		},
    }
</script>

<style>
    .demo-upload-list{
        display: inline-block;
        width: 100%;
        /* height: 60px; */
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 70px 2px;
    }
</style>
