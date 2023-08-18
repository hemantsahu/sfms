<?php

//print_order.php

if(isset($_GET["action"], $_GET["code"]) && $_GET["action"] == 'pdf')
{
	include('database_connection.php');

	$query = "
	SELECT * FROM sfms_setting 
	LIMIT 1
	";

	$school_result = $connect->query($query, PDO::FETCH_ASSOC);

	$school_name = '';
	$school_address = '';
	$school_email_address = '';
	$school_website = '';
	$school_contact_number = '';

	foreach($school_result as $school_row)
	{
		$school_name = $school_row['school_name'];
		$school_address = $school_row['school_address'];
		$school_email_address = $school_row['school_email_address'];
		$school_website = $school_row['school_website'];
		$school_contact_number = $school_row['school_contact_number'];
	}

	$html = '
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
				<h2 align="center" style="margin-bottom:15px;">'.$school_name.'</h2>
				<div align="center" style="margin-bottom:6px">'.$school_address.'</div>
				<div align="center"><b>Phone No. : </b>'.$school_contact_number.' &nbsp;&nbsp;&nbsp;<b>Email : </b>'.$school_email_address.'</div>
				<div align="center" style="margin-bottom:6px"><b>Website : </b>'.$school_website.'</div>
			</td>
		</tr>
		<tr>
			<td>
	';

	$fee_query = "
	SELECT sfms_student.student_number, sfms_student.student_name, sfms_acedemic_year.acedemic_start_year, sfms_acedemic_year.acedemic_start_month, sfms_acedemic_year.acedemic_end_year, sfms_acedemic_year.acedemic_end_month, sfms_fees.fees_month, sfms_fees.fees_data, sfms_acedemic_standard.acedemic_standard_name, sfms_acedemic_standard.acedemic_standard_division, sfms_admin.admin_name, sfms_fees_paid.fees_paid_on, sfms_fees_paid.fees_paid_id  
	FROM sfms_fees_paid 
	INNER JOIN sfms_student 
	ON sfms_student.student_id = sfms_fees_paid.student_id 
	INNER JOIN sfms_acedemic_year 
	ON sfms_acedemic_year.acedemic_year_id = sfms_fees_paid.acedemic_year_id 
	INNER JOIN sfms_fees 
	ON sfms_fees.fees_id = sfms_fees_paid.fees_id 
	INNER JOIN sfms_acedemic_standard 
	ON sfms_acedemic_standard.acedemic_standard_id = sfms_fees_paid.acedemic_standard_id 
	INNER JOIN sfms_admin 
	ON sfms_admin.admin_id = sfms_fees_paid.fees_received_by 
	WHERE sfms_fees_paid.fees_paid_id = '".$_GET["code"]."'
	";

	$fee_result = $connect->query($fee_query, PDO::FETCH_ASSOC);

	$created_by = '';
	$student_number = '';

	foreach($fee_result as $fee_row)
	{
		$html .= '
				<div align="right">'.date("d/m/Y H:i:s", $fee_row["fees_paid_on"]).'</div>
				<table border="1" width="100%" cellpadding="5" cellspacing="0">
					<tr>
						<td width="100%" colspan="2">
							<table width="100%" cellpadding="5" cellspacing="0">
								<tr>
									<td width="30%"><b>Student Number</b></td>
									<td width="70%">'.$fee_row["student_number"].'</td>
								</tr>
								<tr>
									<td width="30%"><b>Student Name</b></td>
									<td width="70%">'.$fee_row["student_name"].'</td>
								</tr>
								<tr>
									<td width="30%"><b>Standard</b></td>
									<td width="70%">'.$fee_row["acedemic_standard_name"].' - '.$fee_row["acedemic_standard_division"].'</td>
								</tr>
								<tr>
									<td width="30%"><b>Academic Year</b></td>
									<td width="70%">'.$fee_row["acedemic_start_month"].' '.$fee_row["acedemic_start_year"].' - '.$fee_row["acedemic_end_month"].' '.$fee_row["acedemic_end_year"].'</td>
								</tr>
								<tr>
									<td width="30%"><b>Fees Month</b></td>
									<td width="70%">'.$fee_row["fees_month"].'</td>
								</tr>
							</table>
						</td>
					</tr>
					
					<tr>
						<td width="100%" colspan="2"><b>Fees Details</b></td>
					</tr>
		';

		$fees_data = json_decode($fee_row['fees_data'], true);

		$total_fee_amount = 0;

		foreach($fees_data as $fees_data_row)
		{
			$html .= '
					<tr>
						<td width="90%">'.$fees_data_row["fees_name"].'</td>
						<td width="10%"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$fees_data_row["fees_value"].'</td>
					</tr>
			';
			$total_fee_amount = $total_fee_amount + $fees_data_row["fees_value"];
		}

		$html .= '
					<tr>
						<td width="90%" align="right"><b>Total</b></td>
						<td width="10%"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.$total_fee_amount.'</td>
					</tr>
				</table>
		';

		$created_by = $fee_row["admin_name"];

		$student_number = $fee_row["student_number"];
	}

	$html .= '				
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="right">Created By '.$created_by.'</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>

	';

	//echo $html;

	require_once('class/pdf.php');

	$pdf = new Pdf();

	$pdf->set_paper('letter');

	$file_name = ''.$student_number .'.pdf';

	$pdf->loadHtml($html);
	$pdf->render();
	$pdf->stream($file_name, array("Attachment" => false));
	exit(0);
}
else
{
	header('location:fees_paid.php');
}

?>