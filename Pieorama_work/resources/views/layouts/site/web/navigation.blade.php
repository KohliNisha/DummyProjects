	<!-- left-panel -->
<div class="left_panel mCustomScrollbar" data-mcs-theme="light-thick">
	<ul>
		<li>
			<a href="{!! url(''); !!}">
				<div class="icon"></div>
				<div class="txt">Home</div>
			</a>
		</li>
    <?php  $navigationList =  Commenhelper::channelDetails()  ;
     if(!$navigationList->isEmpty()) { 
         foreach ($navigationList as $key => $navitem) {
     	?>              
		<li>
			<a href="{!! url('pieograms/'.$navitem->id.'/'.$navitem->channel_title)  !!}">
				<div class="comman-iconStyle" style="background: url({{ $navitem->channel_logo_img }})"></div>
				<div class="txt">{{ $navitem->channel_title }}</div>
			</a>
		</li> 
    <?php } } ?>

	</ul>
</div>
