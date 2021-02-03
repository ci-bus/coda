<?php
$extension = substr($archivo,-3);
if($extension == 'pdf' || $extension == 'PDF'){
						$img = '../images/icon_pdf.png';
						}
					else if($extension == 'DOC' || $extension == 'doc'){
						$img = '../images/icon_word.png'; 
						}
					else if($extension == 'kmz' || $extension == 'KMZ'){
						$img = '../images/icon_kmz.png';
						}
					else if($extension == 'jpg' || $extension == 'JPG'){
						$img = '../images/icon_jpg.png';
						}
					else if($extension == 'xls' || $extension == 'XLS'){
						$img = '../images/icon_excel.png';
						}	
					else{
						$img = '../images/icon_no.png';
						}
?>