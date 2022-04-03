    <!------------------------------top_sider_bar.php:begin------------------------------>

    <div>
    	<table class="table table-hover">
    		<tbody>
			<div>
		<?php
            include('menu01.php');
            for($i=0; $i<count($link); $i++){
                echo "<tr><td>";
                echo "<a href=\"{$link[$i]}\">{$display_name[$i]}</a>";
                echo "</td></tr>\n";
            }
    	?>
			</div>
    	    </tbody>
  		</table>
       
	</div>

    <!------------------------------top_sider_bar.php:end-------------------------------->
