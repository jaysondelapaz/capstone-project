<?php
function StatusColor($status){
		switch ($status) {
			case 'Confirmed':
						echo'<td style="color:green">'.$status.'</td>';
				break;
			case 'Cancelled':
						echo'<td style="color:red">'.$status.'</td>';
				break;
			case 'Posted':
						echo'<td style="color:orange">'.$status.'</td>';
				break;	

			default:
						echo'<td style="color:blue">'.$status.'</td>';
				break;
		}
	}

	function Designation($position){
		switch ($position) {
			case '0':
						echo'<td>Driver</td>';
				break;
			case '1':
						echo'<td>Administrator</td>';
				break;
			case '2':
						echo'<td>Accounting</td>';
				break;
			case '3':
						echo'<td>Marketing</td>';
				break;
			case '4':
						echo'<td>IT</td>';
				break;
			case '5':
						echo'<td>Auditor</td>';
				break;


			default:
						echo'<td>None</td>';
				break;
		}
	}
?>