<template>
<div>
      <section>
        <div class="container gradient1 container1">
          <div class="background-img">
            <div class="box">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
              <div class="content">
                <h1 class="mt-4">Login</h1>
                <form @submit.prevent="login">
                        <div class="login-form">                               
                                <div class="form-group row mb-2"  style="text-align: left;">
                                    <label class="col-md-4 col-form-label text-md-right h4 ">Email</label>
                                    <input type="email" v-model="email" class="form-control2" placeholder="email" required="required">
                                </div>

                                <div class="form-group row mb-2 " style="text-align: left;">
                                    <label class="col-md-4  col-form-label text-md-right h3">Password</label>
                                    <input type="password" v-model="password"  class="form-control2" placeholder="password" required="required">
                                </div>

                                <div class="mb-2">
                                  <input type="submit"  value="Sign In" style="height:30px;width:70px">
                                </div>

                                <div class="clearfix">
                                    <label class="float-left form-check-label mb-2"><input type="checkbox"> Remember me</label>
                                </div>        
                            
                             <div class="text-dark">
                            <a href="#"  class="text-center text-white ">Forgot Password?</a>
                            <p>
                                    <a class="text-white" data-toggle="modal" href="#exampleModalCenter">Create an Account</a>
                            </p>
                              </div> 
                              
                            </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
      </section>
</div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
    }
    },
    async created() {
        const role = localStorage.getItem('role');
        if(localStorage.getItem('token')){
            const role = localStorage.getItem('role');
            if(role=='teacher'){
                this.$router.push('/teacher/dashboard');
            }
            else if(role=='admin'){
                 this.$router.push({ name: 'TestEntry' });
            }
        }
    },
    methods: {
    async login() {
        const response = await this.$http.post('http://127.0.0.1:8000/api/adminLogin', {
          email: this.email,
          password: this.password
        });
        
        if(response.data.flag=='1'){
          localStorage.setItem('token', response.data.user.id);
          localStorage.setItem('role', response.data.user.role);
          if(response.data.user.role=='admin'){
            this.$router.push('TestEntry');
          }
          else if(response.data.user.role=='Receptionist'){
            this.$router.push('PatientEntry');
          }
          else if(response.data.user.role=='Lab'){
            this.$router.push('PatientListLab');
          }
        }
        else {
          alert(response.data.msg);
        }
      },
    }
}
</script>

<style>
.bg
{
    background-color: skyblue;
}

.inbox
{
    background: linear-gradient(to right, #c0c0aa, #1cefff);
}

  @media (min-width: 768px) 
{
 .modal-xl {
  width: 100%;
  max-width:1000px;
}
}


.gradient
{
    /* background: linear-gradient(to right, #9cecfb, #65c7f7, #0052d4); */
   background:  #00C9FF;

}
.gradient1
{
   background:  #00C9FF;
    /* background: linear-gradient(to right, #9cecfb, #65c7f7, #0052d4); */
}


  body{
   background:  #00C9FF;
    /* background: linear-gradient(to right, #9cecfb, #65c7f7, #0052d4); */
  }

  
  .background-img{
    /* background-image: url("https://3.bp.blogspot.com/-piZWCW2uUbg/W2fPXxkWZgI/AAAAAAAAOu0/eydmMjTIqcwLMHEEr2H7imqoRTxMw4o9QCLcBGAs/s1600/among_trees_night_dribbble.png");  */
     /*background-image: url("../assets/med.jpg");*/
    opacity: 0.85;
  height: 480px;
    width: 900px;
    background-repeat: no-repeat;
    background-size: cover;
    margin: 5% auto;
    padding:20px;
    border: 1px solid #2a3cad;
    border-radius: 4px;
    box-shadow: 0px 0px 5px #2a3cad;
    position: relative;
  }
/*   
  .content h2{ font-size:19px;} */
  
  .box{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    height: 400px;
    background: #111845a6;
    box-sizing: border-box;
    overflow: hidden;
    box-shadow: 0 20px 50px rgb(23, 32, 90);
    border: 2px solid #2a3cad;
    color: white;
    padding: 20px;
  }
  
  .box:before{
    content: '';
    position:absolute;
    top:0;
    left:-100%;
    width:100%;
    height:100%;
    background: rgba(255,255,255,0.1);
    transition:0.5s;
    pointer-events: none;
  }
/*   
  .box:hover:before{
    left:-50%;
    transform: skewX(-5deg);
  } */
  
  
  .box .content{
    position:absolute;
    top:15px;
    left:15px;
    right:15px;
    bottom:15px;
    border:1px solid #f0a591;
    padding:20px;
    text-align:center;
    box-shadow: 0 5px 10px rgba(9,0,0,0.5);
    
  }
  
  .box span{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
    box-sizing: border-box;
    
  }
  
  .box span:nth-child(1)
  {
    transform:rotate(0deg);
  }
  
  .box span:nth-child(2)
  {
    transform:rotate(90deg);
  }
  
  .box span:nth-child(3)
  {
    transform:rotate(180deg);
  }
  
  .box span:nth-child(4)
  {
    transform:rotate(270deg);
  }
  
  .box span:before
  {
    content: '';
    position: absolute;
    width:100%;
    height: 2px;
    background: #50dfdb;
    animation: animate 4s linear infinite;
  }
  
  @keyframes animate {
    0% {
    transform:scaleX(0);
    transform-origin: left;
    }
    50%
    {
      transform:scaleX(1);
    transform-origin: left;
    }
    50.1%
    {
      transform:scaleX(1);
    transform-origin: right;
      
    }
    
    100%
    {
      transform:scaleX(0);
    transform-origin: right;
      
    }  
  } 


.login-form {
    width: 340px;
    margin: 50px auto;
  	font-size: 15px;
}
.login-form form {
    margin-bottom: 15px;
    
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    padding: 30px;
}
.login-form h2 {
    margin: 0 0 15px;
}
.form-control1, .btn {
    height: 28px;
    width: 200px;
    border-radius: 2px;
}
.form-control2, .btn {
  height: 28px;
  width: 220px;
  border-radius: 2px;
}
.btn {        
    font-size: 15px;
    font-weight: bold;
}

</style>