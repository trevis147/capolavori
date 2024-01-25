

</div>



<!-- JS Padrão -->

<script src="<?php echo $Config['Url'];     ?>assets/js/bootstrap.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/ace-elements.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/ace.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/script.js"></script>

<?php if(isset($Ckeditor_include_on) && $Ckeditor_include_on){  ?>
<script src="<?php echo $Config['Url'];     ?>ckeditor/ckeditor.js"></script>
<?php  } 					    ?>

<script src="<?php  echo $Config['Url'];  ?>assets/js/jquery.mask.js"></script> 

<script src="<?php echo $Config['Url'];    ?>js/sweetalert.min.js" ></script> 

<!--<script>
	$(document).ready(function(){
		$('#HtmlInpValor').mask('00000000000000.00', {reverse: true});
	});
</script>-->

<!-- JS Datatable -->

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.dataTables.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>



<!-- JS Dropzone -->

<!--<script src="<?php echo $Config['Url'];     ?>assets/js/dropzone.js"></script>-->



<!-- JS Datepiker -->

<script src="<?php echo $Config['Url'];     ?>assets/js/moment.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/daterangepicker.js"></script>



<!-- JS Confirm -->

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.confirm.js"></script>



<!-- JS Crop -->

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.crop.js"></script>



<!-- JS Outros -->

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery-ui.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/waypoints.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/waypoints-sticky.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.hideseek.min.js"></script>

<script src="<?php echo $Config['Url'];     ?>assets/js/jquery.bootstrap-duallistbox.min.js"></script>



</body>

</html>