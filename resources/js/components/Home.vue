<template>
   <div class="container">
       <div class="modal is-active" v-if="showForm">
           <div class="modal-background"></div>
           <div class="modal-card">
               <header class="modal-card-head">
                   <p class="modal-card-title">Tiền ăn hàng ngày</p>
                   <button @click="closeShowForm" class="delete" aria-label="close"></button>
               </header>
               <section class="modal-card-body">

                       <div class="field">
                           <label class="label">Nhập tiền ăn</label>
                           <div class="control">
                               <currency-input class="input" :class="{'is-danger ':!$v.total_db.required ,' is-success':$v.total_db.required }" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  placeholder="Nhập tiền ăn VD:50.000 VNĐ" v-model="total_db"v-currency="{currency: 'VND', locale: 'vn'}" />
                           </div>
                           <div class="text-danger" v-if="!$v.total_db.required" @input="setTotal($event.target.value)">Bạn phải nhập tiền ăn</div>
                        </div>
                       <div class="field" v-if="isDisabled">
                           <label class="label">Chọn những người ăn</label>
                           <div class="control">
                               <p>
                                   <input type="checkbox" id="1" value="1"  v-model="checkName">
                                   <label for="1" data-content="Đàm Nguyễn">Đàm Nguyễn</label>
                               </p>
                               <p>
                                   <input type="checkbox" id="2" value="2"  v-model="checkName">
                                   <label for="2" data-content="Đức Lê">Đức Lê </label>
                               </p>
                               <p>
                                   <input type="checkbox" id="3" value="3"   v-model="checkName">
                                   <label for="3" data-content="Tùng Dương">Tùng Dương </label>
                                </p>
                               <p>
                                   <input type="checkbox" id="4" value="4"   v-model="checkName">
                                   <label for="4" data-content="Dũng Mạnh">Dũng Mạnh </label>
                              </p>
                           </div>
                       </div>
               </section>
               <footer class="modal-card-foot">
                   <button class="button is-success" :disabled="!$v.total_db.required || !$v.checkName.required" @click="submitNote(form)"> Hoàn thành</button>
                   <button class="button" @click="closeShowForm">Hủy bỏ</button>
               </footer>
           </div>
       </div>
        <div>
            <button class="button is-primary" @click="openShowForm">Nhập tiền ăn</button>
        </div>
       <div class="calculate  ">
            <div class="columns">
                <div class="column">
                    <p>Tổng tiền đàm mua :{{total_dam_buy |formatNumber}}</p>
                    <p>Tổng tiền đàm ăn :{{total_dam_eat |formatNumber}}</p>
                    <p>Tiền phải trả :{{total_dam_buy - total_dam_eat |formatNumber}}</p>
                </div>
                <div class="column">
                    <p>Tổng tiền đức mua :{{total_duc_buy |formatNumber}}</p>
                    <p>Tổng tiền đức ăn :{{total_duc_eat |formatNumber}}</p>
                    <p>Tiền phải trả :{{total_duc_buy - total_duc_eat |formatNumber}}</p>
                </div>
            </div>
           <div class="columns">
                <div class="column">
                    <p>Tổng tiền tùng dương mua:{{total_tungduong_buy |formatNumber}}</p>
                    <p>Tổng tiền tùng dương ăn:{{total_tungduong_eat |formatNumber}}</p>
                    <p>Tiền phải trả :{{total_tungduong_buy - total_tungduong_eat |formatNumber}}</p>
                </div>
                <div class="column">
                    <p>Tổng tiền dũng mạnh mua:{{total_dungmanh_buy |formatNumber}}</p>
                    <p>Tổng tiền dũng mạnh ăn:{{total_dungmanh_eat |formatNumber}}</p>
                    <p>Tiền phải trả :{{total_dungmanh_buy - total_dungmanh_eat |formatNumber}}</p>
                </div>
            </div>
       </div>
       <div class="is-centered has-text-centered">
           <div style="padding-right: 6px">Ký hiệu người đi mua :</div>
           <div>
               <span class="tag is-success">Đàm</span>
               <span class="tag is-primary">Đức</span>
               <span class="tag is-danger">Tùng Dương</span>
               <span class="tag is-warning">Dũng Mạnh</span>
           </div>

       </div>
       <div class="is-center-total">
           <button class="button is-danger is-small" @click="deleteAll" :disabled="selected.length==0 ">Xóa tất cả </button>
           <button class="button is-danger is-small" @click="toggleDelete" v-if="showDelete">Tắt xóa thủ công</button>
           <button class="button is-info is-small"   @click="toggleDelete" v-else="!showDelete">Bật xóa thủ công</button>
       </div>
       <div class="table-container">
           <table class=" table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
              <tr>
                  <th> <input type="checkbox" v-model="selectAll" @click="select"></th>
                  <th>STT</th>
                  <th>Ngày mua</th>
                  <th>Đàm</th>
                  <th>Đức</th>
                  <th>Tùng Dương</th>
                  <th>Dũng Mạnh</th>
                  <th>Tổng tiền</th>
                  <th v-show="showDelete">Hành động</th>
              </tr>
               <tr v-for="(money,index) in listMoney" :key="index">

                   <td>
                       <input type="checkbox" :value="money.id" v-model="selected">
                   </td>
                   <td>{{index+1}} </td>
                   <td>{{money.created_at | moment}}</td>
                   <td>{{money.sub_total.dam |formatNumber}}</td>
                   <td>{{money.sub_total.duc |formatNumber}}</td>
                   <td>{{money.sub_total.tungduong |formatNumber}}</td>
                   <td>{{money.sub_total.dungmanh |formatNumber}}</td>
                   <td  class="tag is-vcentered is-center-total " :class="{'tag is-success':money.isPrimary,'is-primary':money.isDanger,'is-warning':money.isInfo,'is-danger':money.isBlu}">{{money.total|formatNumber}}</td>
                   <td  v-show="showDelete"><button class="btn btn-danger "  @click="gotoDelete(money,index)">Xóa {{ }}</button></td>
               </tr>
           </table>
       </div>
   </div>
</template>

<script>
    import moment from "moment";
    import EventBus from "../EventBus";
    import { required, minLength, between } from 'vuelidate/lib/validators'
    import { CurrencyInput } from 'vue-currency-input'
    export default {
        name: "Home",
        data(){
            return{
                form:{
                    total:'',
                    time:1,
                    subtotal:{
                        dam:0,
                        duc:0,
                        tungduong:0,
                        dungmanh:0
                    }
                },
                showForm:false,
                listMoney:[],
                isSave:false,
                isDisabled:false,
                total_db:'',
                checkName:[],

                dam:0,
                duc:0,
                tungduong:0,
                dungmanh:0,

                total_dam_buy:0,
                total_duc_buy:0,
                total_tungduong_buy:0,
                total_dungmanh_buy:0,

                total_dam_eat:0,
                total_duc_eat:0,
                total_tungduong_eat:0,
                total_dungmanh_eat:0,

                user:{},
                 selected: [],
                selectAll: false,
                showDelete:false,
            }
        },
        validations: {
            total_db:{
                required
            },
            checkName:{
              required
            }
        },
        mounted() {
        },
        methods:{
            toggleDelete(){
              this.showDelete =!this.showDelete;
            },
            deleteAll(){
                axios.post('api/delete/all',this.selected)
                    .then (res =>{
                        //
                        this.getListMoney();
                    })
                    .catch(err =>{
                        console.log(err);
                    })

            },
            select() {
                this.selected = [];
                if (!this.selectAll) {
                    for (let i in this.listMoney) {
                        this.selected.push(this.listMoney[i].id);
                    }
                }
            },
            resetMoney(){
                    this.total_dam_buy=0;
                    this.total_duc_buy=0;
                    this.total_tungduong_buy=0;
                    this.total_dungmanh_buy=0;

                    this.total_dam_eat=0;
                    this.total_duc_eat=0;
                    this.total_tungduong_eat=0;
                    this.total_dungmanh_eat=0;
            },
            setTotal(value) {
                this.total_db = value
            },
            setCheckbox(value){
                this.checkName=value
            },
            gotoDelete(value,index){
                axios.delete('api/delete/'+value.id)
                .then (res =>{
                    //
                    this.listMoney.splice(index,1);
                })
                .catch(err =>{
                    console.log(err);
                })
            },
            openShowForm(){
                this.showForm=true;
            },
            closeShowForm(){
                this.dam=0;
                this.duc=0;
                this.tungduong=0;
                this.dungmanh=0;
                this.total_db='';
                this.showForm=false;
            },
            handleCalculate(){
                let tiendachia=0;
                tiendachia=Math.ceil(parseFloat( this.total_db) /this.checkName.length);
                if(this.checkName){
                    this.checkName.map(item =>{
                        if(item ==1){
                            this.dam=tiendachia;

                        }

                        if(item ==2){
                            this.duc=tiendachia;
                        }

                        if(item ==3){
                            this.tungduong=tiendachia;

                        }

                        if(item ==4){
                            this.dungmanh=tiendachia;
                        }

                    })
                }
            },
            submitNote(){
                this.handleCalculate();
                this.resetMoney();
                this.checkName=[];
                this.form.total=this.total_db;
                this.form.subtotal.dam=this.dam;
                this.form.subtotal.duc=this.duc;
                this.form.subtotal.tungduong=this.tungduong;
                this.form.subtotal.dungmanh=this.dungmanh;
                axios.post('api/create',this.form)
                    .then(res =>{
                        this.closeShowForm();
                        this.total_db='';
                        this.form.total='';
                        this.form.subtotal.dam='';
                        this.form.subtotal.duc='';
                        this.form.subtotal.tungduong='';
                        this.form.subtotal.dungmanh='';
                        this.getListMoney();
                    })
                    .catch( err =>{
                        console.log(err)
                    })
            },
            getListMoney(){
                axios.get('api/list')
                    .then(res =>{
                        this.listMoney=res.data.data;
                       this.calculateBuy(this.listMoney);
                       this.calculateEat(this.listMoney);
                        this.handleAddClass();

                    })
                    .catch( err =>{
                        console.log(err)
                    })
            },
            calculateBuy(value){
                value.map(item =>{
                   if(item.who_id == 1){
                       console.log(item.total)
                     this.total_dam_buy  += item.total;
                   }
                   if(item.who_id == 2){
                        this.total_duc_buy  += item.total;
                    }
                   if(item.who_id == 3){
                        this.total_tungduong_buy  += item.total;
                    }
                   if(item.who_id == 4){
                        this.total_dungmanh_buy  += item.total;
                    }

                });
            },
            calculateEat(value){
              value.map( item =>{
                  this.total_dam_eat +=item.sub_total.dam;
                  this.total_duc_eat +=item.sub_total.duc;
                  this.total_tungduong_eat +=item.sub_total.tungduong;
                  this.total_dungmanh_eat +=item.sub_total.dungmanh;
              });

            },


        },

        computed:{
            handleAddClass(){
                this.listMoney.map(item =>{
                    if(item.who_id ==1){
                        item.isPrimary=true;
                    }
                    if(item.who_id ==2){
                        item.isDanger=true;

                    }
                    if(item.who_id ==3){
                        item.isBlu=true;
                    }
                    if(item.who_id ==4){
                        item.isInfo=true;
                    }
                })
            }
        },
        watch:{
            checkName:{
             handler(){
                 this.setCheckbox(this.checkName);

                }
            },
            total_db:{
                handler(){
                    if(this.total_db >0){

                        this.isDisabled=true
                    }
                    else {
                        this.isDisabled=false;
                        this.dam=0;
                        this.duc=0;
                        this.tungduong=0;
                        this.dungmanh=0;
                    }
                }
            }
        },
        components: { CurrencyInput },

        created() {
            this.getListMoney();
            EventBus.$on('user',function (value) {
            this.user=value;
            })
        },
        destroyed() {

        },
        filters: {
            formatNumber:function(num) {
                     return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') +' VNĐ'
             },
            moment: function (date) {
                return moment(date).format('YYYY-MM-DD');
            }

        }

    }
</script>

<style lang="scss" scoped>
    .is-centered{
        padding-top: 20px;
        padding-bottom: 30px;
        display: flex;
    }
    .is-center-total{
       margin:10px
    }
    .header {
        width: 500px;
        display: flex;
    }
    .pd-6{
        padding-right: 30px;
    }
    .is-pulled-right{
        cursor: pointer;
    }
    .note-content{
        padding-bottom: 10px;
        border-bottom: 1px solid gray;
    }
    .is-hover{
        cursor: pointer;
    }
    .yellow{
        color: yellow;
    }
    .bg-primary{
        color: #1f6fb2;
    }
    .bg-danger{
        color: red;
    }
    .bg-info{
        color: #4aa0e6;
    }
    .bg-blu{
        color: #2a9055;
    }
    $black: #363839;
    $lightgray: #9c9e9f;
    $gray: #bdc1c6;
    $white: #fff;
    $green: #06842c;

    * {
        box-sizing: border-box;
        &::before, &::after {
            box-sizing: border-box;
        }
    }


    input[type="checkbox"] {
        position: relative;
        width: 1.5em;
        height: 1.5em;
        color: $black;
        border: 1px solid $gray;
        border-radius: 4px;
        appearance: none;
        outline: 0;
        cursor: pointer;
        transition: background 175ms cubic-bezier(0.1, 0.1, 0.25, 1);
        &::before {
            position: absolute;
            content: '';
            display: block;
            top: 2px;
            left: 7px;
            width: 8px;
            height: 14px;
            border-style: solid;
            border-color: $white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
        }
        &:checked {
            color: $white;
            border-color: $green;
            background: $green;
            &::before {
                opacity: 1;
            }
            ~ label::before {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
        }
    }

    label {
        position: relative;
        cursor: pointer;
        font-size: 1.5em;
        font-weight: 600;
        padding: 0 0.25em 0;
        user-select: none;
        &::before {
            position: absolute;
            content: attr(data-content);
            color: $lightgray;
            clip-path: polygon(0 0, 0 0, 0% 100%, 0 100%);
            text-decoration: line-through;
            text-decoration-thickness: 3px;
            text-decoration-color: $black;
            transition: clip-path 200ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    }

</style>
