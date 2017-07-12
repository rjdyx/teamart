<?php 
	$system = App\System::find(1);
	$qq = '';
	if (count($system)) {
		$qq = $system->qq;
	}
 ?>
<a class="floatkefu J_kefu" target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$qq}}&site=qq&menu=yes">
	<i class="fa fa-headphones fz-20"></i>
</a>
<script src="{{url('/fx/js/Inertia.js')}}"></script>
<script>
	new Inertia(document.querySelector('.J_kefu'), {
		edge: false
	});
</script>
