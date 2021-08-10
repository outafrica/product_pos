<template>
   <div>
		<div class="content">
			<div class="container-fluid">
					
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Expense <Button @click="showaddExpenseModal"><Icon type="md-add"/> Add Expense</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Type</th>
								<th>Sub Type</th>
								<th>Beneficiary Name</th>
								<th>Amount</th>
								<th>Month Paid</th>
								<th>Actions</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(expense, c) in expenses " :key="c" v-if="expenses.length">
								<td>{{c + 1}}</td>
								<td>{{expense.type}}</td>
								<td>{{expense.sub_type}}</td>
								<td class="_table_name">{{expense.beneficiary_name}}</td>
								<td>{{expense.amount}}</td>
								<td>{{expense.month_paid}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(expense, c)">Edit</Button>
									<Button type="error" size="small" @click="showDeleteModal(expense, c)" :loading="expense.isDeleting">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->
						</table>
					</div>
					<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Expense addition modal ~~~~~~~~~-->

					 <Modal
						v-model="addExpenseModal"
						title="Add Expense"
						:mask-closable="false"
						:closable="false"
						>

						<Select v-model="data.type" placeholder="Select Expense Type" filterable>
                            <Option v-for="(expensetype, expt) in expensetypes" :key="expt" :value="expensetype.name">{{ expensetype.name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Select v-model="data.sub_type" placeholder="Select Expense Type" filterable>
                            <Option v-for="(expensesubtype, expst) in expensesubtypes" :key="expst" :value="expensesubtype.name">{{ expensesubtype.name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Input v-model="data.beneficiary_name" placeholder="Beneficiary Name" />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.receipt_number" placeholder="Receipt Number" />

                        <div style="margin: 10px;"></div>

						<Input v-model="data.amount" type="number" placeholder="Amount Paid" />

                        <div style="margin: 10px;"></div>

                        <DatePicker v-model="data.month_paid" type="date" style="width: 487px;" placeholder="Month Paid"></DatePicker>

                        <div style="margin: 10px;"></div>
						
                        <div slot="footer">
							<Button type="success" @click="addExpense" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add Expense'}}</Button>
							<Button type="error" @click="addExpenseModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Expense addition modal ~~~~~~~~~-->


					<!--~~~~~~~ Begining of Expense editing modal ~~~~~~~~~-->

					 <Modal
						v-model="editExpenseModal"
						title="Edit Expense"
						:mask-closable="false"
						:closable="false"
						>
						<Select v-model="editData.type" placeholder="Select Expense Type" filterable>
                            <Option v-for="(expensetype, expt) in expensetypes" :key="expt" :value="expensetype.name">{{ expensetype.name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Select v-model="editData.sub_type" placeholder="Select Expense Type" filterable>
                            <Option v-for="(expensesubtype, expst) in expensesubtypes" :key="expst" :value="expensesubtype.name">{{ expensesubtype.name }}</Option>
                        </Select>

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.beneficiary_name" placeholder="Beneficiary Name" />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.receipt_number" placeholder="Receipt Number" />

                        <div style="margin: 10px;"></div>

						<Input v-model="editData.amount" type="number" placeholder="Amount Paid" />

                        <div style="margin: 10px;"></div>

                        <DatePicker v-model="editData.month_paid" type="date" style="width: 487px;" placeholder="Month Paid"></DatePicker>

                        <div style="margin: 10px;"></div>

						<div slot="footer">
							<Button type="success" @click="editExpense" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing...' : 'Submit'}}</Button>
							<Button type="error" @click="editExpenseModal=false">Close</Button>
						</div>
					</Modal>

					<!--~~~~~~~ End of Expense editing modal ~~~~~~~~~-->

					<!--~~~~~~~ Begining of Expense delete modal ~~~~~~~~~-->
					
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

					<!--~~~~~~~ End of Expense delete modal ~~~~~~~~~-->



				</div>
			</div>
		</div>
	</div>
</template>

<script>

    import moment from 'moment'

    export default {
		data () {
           return {

            data: {
                type: '',
                sub_type: '',
                beneficiary_name: '',
                receipt_number: '',
                amount: 0,
                month_paid: new Date(),
            },
            addExpenseModal: false,
            isAdding: false,
            expenses: [],
            expensetypes:[],
            expensesubtypes:[],
            editExpenseModal: false,
            isEditing: false,
            editData: {
                type: '',
                sub_type: '',
                beneficiary_name: '',
                receipt_number: '',
                amount: 0,
                month_paid: new Date(),
            },
            index: -1,
            deleteModal: false,
            deleteData: {},
            modal_loading: false,
            token: '',
            isEditingImage: false,

			}
       },
       methods: {
           async showaddExpenseModal(){
                
                const [resTypes, resSub] = await Promise.all([

                    this.callApi('get', '/admin/expenses/expenses_types'),
                    this.callApi('get', '/admin/expenses/expense_sub_types')

                ]);

                if(resTypes.status == 200 && resSub.status == 200){

                    this.expensesubtypes = resSub.data;
                    this.expensetypes = resTypes.data;
                    this.addExpenseModal = true;
                    
                }else{

                    this.d();

                }

           },
		   async addExpense(){
			   
				if(this.data.type.trim() == ''){
				   return this.e('The Expense name is required');
				}else if(this.data.type.trim() == ''){
				   return this.e('The Beneficiary name is required');
				}else if(this.data.beneficiary_name.trim() == ''){
				   return this.e('The Beneficiary name is required');
				}else if(this.data.amount == 0){
				   return this.e('Amount paid is required');
				}

                this.data.month_paid = moment(String(this.data.month_paid)).format('YYYY-MM-DD hh:mm');

				const res = await this.callApi('post', '/admin/expenses/create_expense', this.data);
				if(res.status == 201){

					this.expenses.unshift(res.data);
					this.s('Expense successfully added');
					this.addExpenseModal=false;
					this.data.type ='';
					this.data.sub_type ='';
					this.data.beneficiary_name ='';
					this.data.receipt_number ='';
					this.data.amount ='';
					this.data.month_paid =  new Date();

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
			async showEditModal(expense, index){
				let obj = {
					id: expense.id,
					type: expense.type,
					sub_type: expense.sub_type,
					beneficiary_name: expense.beneficiary_name,
					receipt_number: expense.receipt_number,
					amount: expense.amount,
					month_paid: expense.month_paid
				}
				this.editData = obj;
				this.index = index;
				
				const [resTypes, resSub] = await Promise.all([

                    this.callApi('get', '/admin/expenses/expenses_types'),
                    this.callApi('get', '/admin/expenses/expense_sub_types')

                ]);

                if(resTypes.status == 200 && resSub.status == 200){

                    this.expensesubtypes = resSub.data;
                    this.expensetypes = resTypes.data;    
					this.editExpenseModal = true;

                }else{

                    this.d();

                }
			},
		    async editExpense(){
			   
			   if(this.editData.type.trim() == ''){
				   return this.e('The Expense name is required');
				}else if(this.editData.type.trim() == ''){
				   return this.e('The Beneficiary name is required');
				}else if(this.editData.beneficiary_name.trim() == ''){
				   return this.e('The Beneficiary name is required');
				}else if(this.editData.amount == 0){
				   return this.e('Amount paid is required');
				}

                this.editData.month_paid = moment(String(this.data.month_paid)).format('YYYY-MM-DD hh:mm');

				const res = await this.callApi('post', '/admin/expenses/edit_expense', this.editData);
				if(res.status == 200){
					this.expenses[this.index].type = this.editData.type;
					this.expenses[this.index].sub_type = this.editData.sub_type;
					this.expenses[this.index].beneficiary_name = this.editData.model_name;
					this.expenses[this.index].receipt_number = this.editData.receipt_number;
					this.expenses[this.index].amount = this.editData.amount;
					this.expenses[this.index].month_paid = this.editData.month_paid;
					this.s('Expense successfully updated');
					this.editExpenseModal = false;
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
			showDeleteModal(expense, index){
				
				this.deleteData = expense;
				this.index = index;
				this.deleteModal = true;
				
			},
			async deleteAction(){

				const res = await this.callApi('post', '/admin/expenses/delete_expense', this.deleteData);
				if(res.status == 200){
					
					setTimeout(() => {
						this.modal_loading = false;
						this.$Message.success('Expense successfully deleted');
					}, 1000);
					this.expenses.splice(this.index, 1);
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

            const res = await this.callApi('get', '/admin/expenses/all_expenses');
			
			if(res.status == 200){
				this.expenses = res.data;
			}else{
				this.d();
            }

		},
    }
</script>