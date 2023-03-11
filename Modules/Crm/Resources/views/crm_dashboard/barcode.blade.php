@extends('crm::layouts.app')
<style>
	input {
    margin-top: 0.5rem;
		
}
.toast {
	
  position: absolute;
  top: 25px;
  right: 30px;
  border-radius: 12px;
 
  padding: 20px 35px 20px 25px;
  box-shadow: 0 6px 20px -5px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transform: translateX(calc(100% + 30px));
  transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.35);
}

.toast.active {
  transform: translateX(0%);
}

.toast .toast-content {
  display: flex;
  align-items: center;
}

.toast-content .check {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 35px;
  min-width: 35px;
  background-color: #2770ff;
  color: #fff;
  font-size: 20px;
  border-radius: 50%;
}

.toast-content .message {
  display: flex;
  flex-direction: column;
  margin: 0 20px;
}

.message .text {
	
  font-size: 16px;
  font-weight: 400;
  color: #666666;
}

.message .text.text-1 {
  font-weight: 600;
  color: #333;
}
	.message .text.text-2 {
		padding:3px;
  font-weight: 300;
  color: #333;
}

.toast .close {
  position: absolute;
  top: 10px;
  right: 15px;
  padding: 5px;
  cursor: pointer;
  opacity: 0.7;
}

.toast .close:hover {
  opacity: 1;
}

.toast .progress {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  width: 100%;

}

.toast .progress:before {
  content: "";
  position: absolute;
  bottom: 0;
  right: 0;
  height: 100%;
  width: 100%;
  background-color: #2770ff;
}

.progress.active:before {
  animation: progress 3s linear forwards;
}

@keyframes progress {
  100% {
    right: 100%;
  }
}


input::placeholder {
    font-weight: bold;
    opacity: .5;
    color: red;
		width:100%;
}
</style>
@section('title', __('lang_v1.all_sales'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
	<div class="toast " style=' background-color:#4BB543;'> <div class="toast-content"> <i class="fas fa-solid fa-check check"></i><div class="message"><span class="text text-1" id='state'>Succès</span><span class="text text-2" id='text_toast'>status changer avec succès</span></div></div><i class="fa-solid fa-xmark close"></i><div class="progress "></div></div>
    <h1>Scanner de code-barres
	<!--	{{auth()->user()}}-->
    </h1>
</section>
<!-- Main content -->
<section class="content no-print" style=' margin-left: 50px;
    margin: auto;
    '>
<form style=' margin-left: 20%; background-color:white; padding:10px;height:30%;'>	
<div class="form-group row" style=' padding:10px;height:20%;'>
			<?php
	$shipping_statuses = [
            'ordered' => __('lang_v1.ordered'),
            //'packed' => __('lang_v1.packed'),
            'shipped' => __('lang_v1.shipped'),
            'delivered' => __('lang_v1.delivered'),
            'cancelled' => 'transférer'
        ];
				 ?>
					 <div class="col-md-6">
				        <div class="form-group">
				            {!! Form::label('shipping_status_modal', __('lang_v1.shipping_status') . ':' ) !!}
				            {!! Form::select('shipping_id',$shipping_statuses, null, ['class' => 'form-control','id' => 'shipping_id','placeholder' => __('messages.please_select')]); !!}
				        </div>
				    </div>
					<div class="col-md-8" id='inputid' style='display:none;'>
				        <div class="form-group">
				            {!! Form::label('status_to_change', 'Scanner de code-barres'. ':' ) !!}
				            {!! Form::text('status_change',  null, ['class' => 'form-control', 'id' => 'status_change','placeholder' => 'Code a barre/Id Produit']); !!}
				        </div>
				    </div>
	<div class="col-md-8" >
				        <div class="form-group">
							{!! Form::label('shipping_note',  __('lang_v1.delivered_to') . ':'  ) !!}
				            {!! Form::text('shipping_note',  null, ['class' => 'form-control', 'id' => 'shipping_note','placeholder' =>  __('lang_v1.delivered_to')]); !!}
				         
				        </div>
				    </div>
                    </div>
	
	</form>	
	<div id="toast"></div>

</section>
@endsection
@section('javascript')
 <script>
	  input.setAttribute('size',input.getAttribute('placeholder').length);
	  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script>
	  

$('#shipping_id').on('change', function() {
	if(this.value=='')
  document.getElementById("inputid").style.display = "none";
	else
		document.getElementById("inputid").style.display = "block";
	
		  

});

function toast() {
    alert('wach');
	  
}
	   toast = document.querySelector(".toast");
	   (closeIcon = document.querySelector(".close")),
  (progress = document.querySelector(".progress"));

let timer1, timer2;
   $("#status_change").on("input", function() {
	   var status=$('#shipping_id').val();
	    var shipping_note=$('#shipping_note').val();
	   var inputval=$(this).val();
	    $.ajax({
              type: "get",
              url: '/contact/barcode_scann',
              data: {  
    id: inputval,  
     shipping_status: status,  
	shipping_note: shipping_note,  
  }, 
              dataType: "json",
              success: function (response) {
				   document.getElementById("text_toast").textContent="status changer avec succès "+status;
				 toast.classList.add("active");
  progress.classList.add("active");

  timer1 = setTimeout(() => {
    toast.classList.remove("active");
  }, 3000); //1s = 1000 milliseconds

  timer2 = setTimeout(() => {
    progress.classList.remove("active");
  }, 3300);
				   },
              error: function(response) {
				  if(response.responseText=='"no_transaction"'){
					 state
					 document.getElementById("state").textContent="Error ";
				  document.getElementById("text_toast").textContent="Error de changer le status y'a pas de location "+status;
				 toast.classList.add("active");
					 toast.style.background = 'red';
  progress.classList.add("active");

  timer1 = setTimeout(() => {
    toast.classList.remove("active");
  }, 3000); //1s = 1000 milliseconds

  timer2 = setTimeout(() => {
    progress.classList.remove("active");
  }, 3300);
				  }
                   
              }

          });
	
});
	  closeIcon.addEventListener("click", () => {
  toast.classList.remove("active");

  setTimeout(() => {
    progress.classList.remove("active");
  }, 300);

  clearTimeout(timer1);
  clearTimeout(timer2);
});
	  	  </script>

@endsection