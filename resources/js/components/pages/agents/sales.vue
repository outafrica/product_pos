<template>
   <div>
		<div class="content">
			<div class="container-fluid">
					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Sales <Button @click="addSaleModal=true"><Icon type="md-add"/> Add Sale</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Product Name</th>
								<th>Model Name</th>
								<th>Quantity Sold</th>
								<th>Selling Price</th>
								<th>Total</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(sale, c) in sales " :key="c">
								<td>{{ c + 1 }}</td>
								<td class="_table_name">{{sale.name}}</td>
								<td>{{sale.model_name}}</td>
								<td>{{sale.quantity_sold}}</td>
								<td>{{sale.selling_price}}</td>
								<td>{{sale.total}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(sale, c)">Edit</Button>
									<!-- <Button type="error" size="small" @click="showDeleteModal(sale, c)" :loading="sale.isDeleting">Delete</Button> -->
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
					<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Sale addition modal ~~~~~~~~~-->

					 <Modal
						v-model="addSaleModal"
						title="Add Sale"
						:mask-closable="false"
						:closable="false"
						>

						<Select v-model="data.product_id" placeholder="Select Product" filterable>
                            <Option v-for="(product, pro) in products" :key="pro" :value="product.id">{{ product.brand }}  {{ product.model_name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Input v-model="data.quantity_sold" type="number" placeholder="Quantity Sold" />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.selling_price" type="number" placeholder="Sale Price" />

                        <div style="margin: 10px;"></div>
						
                        <div slot="footer">
							<Button type="success" @click="addSale" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Sale'}}</Button>
							<Button type="error" @click="addSaleModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Sale addition modal ~~~~~~~~~-->


					<!--~~~~~~~ Begining of Sale editing modal ~~~~~~~~~-->

					 <Modal
						v-model="editSaleModal"
						title="Edit Sale"
						:mask-closable="false"
						:closable="false"
						>
						<Select v-model="editData.model_name" placeholder="Select Product" filterable disabled>
                            <Option v-for="(product, pro) in products" :key="pro" :value="product.model_name">{{ product.model_name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.selling_price" type="number" placeholder="Sale Price" disabled />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.quantity_sold" type="number" placeholder="Quantity" />

                        <div style="margin: 10px;"></div>

						<div slot="footer">
							<Button type="success" @click="editSale" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing...' : 'Submit'}}</Button>
							<Button type="error" @click="editSaleModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Sale editing modal ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Sale delete modal ~~~~~~~~~-->
					
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

					<!--~~~~~~~ End of Sale delete modal ~~~~~~~~~-->

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
					product_id: '',
                    quantity_sold: '',
                    selling_price: '',
				},
				addSaleModal: false,
				isAdding: false,
				sales: [],
				pro_bp: 0,
                products: [],
				editSaleModal: false,
				isEditing: false,
				editData: {
					model_name:'',
					product_id: '',
                    quantity_sold: '',
                    selling_price: '',
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
		   async addSale(){

			     for(let i in this.products){
					if(this.data.model_name == this.products[i].model_name){
						this.pro_bp = this.products[i].buying_price;
					}
				}

				// console.log(this.pro_bp);
			   
				if(this.data.quantity_sold.trim() == 0){
				   return this.e('The Quatity sold is required');
				}else if(this.data.selling_price < this.pro_bp ){
				   return this.e('Selling price is less than allowed price');
				}
				const res = await this.callApi('post', '/agent/sales/create_sale', this.data);
				if(res.status == 201){

					this.sales.unshift(res.data);
					this.s('Sale successfully added');
					this.addSaleModal=false;
					this.data.name ='';
					this.data.image ='';


				}else{
					
					if(res.status == 422){
						for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
					}else if(res.status == 430){
                            this.e(res.data);
					}else{					
						this.d();
					}					

				}

			},
			showEditModal(sale, index){
				let obj = {
					id: sale.id,
					name: sale.name,
					model_name: sale.model_name,
					quantity_sold: sale.quantity_sold,
					selling_price: sale.selling_price
				}
				this.editData = obj;
				this.editSaleModal = true;
				this.index = index;
			},
		    async editSale(){
			   
			   if(this.editData.quantity_sold.trim() == 0){
				   return this.e('The quatity sold is required');
				}

			   const res = await this.callApi('post', '/agent/sales/edit_sale', this.editData);
				if(res.status == 200){
					this.sales[this.index].quantity_sold = this.editData.quantity_sold;
					this.sales[this.index].total = this.editData.selling_price * this.editData.quantity_sold;
					this.s('Sale successfully updated');
					this.data.image = '';	
					this.editSaleModal = false;
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
			showDeleteModal(sale, index){
				
				this.deleteData = sale;
				this.index = index;
				this.deleteModal = true;
				
			},
			async deleteAction(){

				const res = await this.callApi('post', '/agent/sales/delete_sale', this.deleteData);
				if(res.status == 200){
					
					setTimeout(() => {
						this.modal_loading = false;
						this.$Message.success('Sale successfully deleted');
					}, 1000);
					this.sales.splice(this.index, 1);
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
			
            const [resSales, resProducts] = await Promise.all([

				this.callApi('get', '/agent/sales/all_sales'),
				this.callApi('get', '/agent/sales/all_products')

			])
			
			if(resSales.status == 200){
				this.sales = resSales.data;
			}else{
				this.d();
			}

			if(resProducts.status == 200){
				this.products = resProducts.data;
			}else{
				this.d();
			}
		},
    }
</script>
