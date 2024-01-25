
<div id="Footer">
    <div class="units-row MaxWid">
        <div class="unit-40">&nbsp;</div>
        <div class="unit-60 Versao">
        	<p>Versão do sistema: <?php echo $Config["Versao"]; ?></p>
        </div>
    </div>
</div>
	
    <?php
		if(isset($DEBUG) && $DEBUG == 1) {
			
			include  $Config["RootDirAdm"]."debug.php";
				
		}
	?>
    
    <script>
		$(document).ready(function() {
            $("span.close").click(function() {
				$(this).parent("div.message").slideUp(200);
			});
        });
	</script>
    
</body>
</html>