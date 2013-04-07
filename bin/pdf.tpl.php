<html>
	<head>
		<style type="text/css">
			#outlook a {
				padding:0;
			}
			body {
				width:100% !important;
			}
			body {
				-webkit-text-size-adjust:none;
			}
			body {
				margin-bottom:0;
				margin-left:0;
				margin-right:0;
				margin-top:10px;
				padding:0;
			}
			img {
				border:0;
				height:auto;
				line-height:100%;
				outline:none;
				text-decoration:none;
			}
			table td {
				border-collapse:collapse;
			}
			#backgroundTable {
				height:100% !important;
				margin:0;
				padding:0;
				width:100% !important;
			}
			body, #backgroundTable {
				background-color:#FAFAFA;
			}
			#templateContainer {
				border:1px solid #DDDDDD;
			}
			h1, .h1 {
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:34px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}
			h2, .h2 {
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:30px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}
			h3, .h3 {
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:26px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}
			h4, .h4 {
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:22px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}
			#templatePreheader {
				background-color:#FAFAFA;
			}
			.preheaderContent div {
				color:#505050;
				font-family:Arial;
				font-size:10px;
				line-height:100%;
				text-align:left;
			}
			.preheaderContent div a:link, .preheaderContent div a:visited, .preheaderContent div a .yshortcuts {
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			#templateHeader {
				background-color:#FFFFFF;
				border-bottom:0;
			}
			.headerContent {
				color:#202020;
				font-family:Arial;
				font-size:34px;
				font-weight:bold;
				line-height:100%;
				padding:0;
				text-align:center;
				vertical-align:middle;
			}
			.headerContent a:link, .headerContent a:visited, .headerContent a .yshortcuts {
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			#headerImage {
				height:auto;
				max-width:600px !important;
			}
			#templateContainer, .bodyContent {
				background-color:#FFFFFF;
			}
			.bodyContent div {
				color:#505050;
				font-family:Arial;
				font-size:14px;
				line-height:150%;
				text-align:left;
			}
			.bodyContent div a:link, .bodyContent div a:visited, .bodyContent div a .yshortcuts {
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			.bodyContent img {
				display:inline;
				height:auto;
			}
			#templateFooter {
				background-color:#FFFFFF;
				border-top:0;
			}
			.footerContent div {
				color:#707070;
				font-family:Arial;
				font-size:12px;
				line-height:125%;
				text-align:left;
			}
			.footerContent div a:link, .footerContent div a:visited, .footerContent div a .yshortcuts {
				color:#336699;
				font-weight:normal;
				text-decoration:underline;
			}
			.footerContent img {
				display:inline;
			}
		</style>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="10" marginheight="0"
	offset="0">
		<center>
			// Background container
			<table border="0" cellpadding="0" cellspacing="0" height="100%"
			width="100%" id="backgroundTable">
				<tbody>
					<tr>
						<td align="center" valign="top">// Email container
						<table border="0" cellpadding="0" cellspacing="0" width="600"
						id="templateContainer">
							<tbody>
								<tr>
									<td align="center" valign="top">// Header container
									<table border="0" cellpadding="0" cellspacing="0" width="600"
									id="templateHeader">
										<tbody>
											<tr>
												<td class="headerContent"></td>
											</tr>
										</tbody>
									</table></td>
								</tr>
								<tr>
									<td align="center" valign="top">// Body container
									<table border="0" cellpadding="0" cellspacing="0" width="600"
									id="templateBody">
										<tbody>
											<tr>
												<td valign="top" class="bodyContent">
												<table border="0" cellpadding="20" cellspacing="0"
												width="100%">
													<tbody>
														<tr>
															<td valign="top"><?php echo $messageHTML; ?></td>
														</tr>
													</tbody>
												</table></td>
											</tr>
										</tbody>
									</table></td>
								</tr>
								<tr>
									<td align="center" valign="top">// Footer container
									<table border="0" cellpadding="10" cellspacing="0"
									width="100%" id="templateFooter">
										<tbody>
											<tr>
												<td valign="top" class="footerContent">
												<table border="0" cellpadding="10" cellspacing="0"
												width="100%">
													<tbody>
														<tr>
															<td colspan="2" valign="middle"></td>
														</tr>
													</tbody>
												</table></td>
											</tr>
										</tbody>
									</table></td>
								</tr>
							</tbody>
						</table>
						<br>
						</td>
					</tr>
				</tbody>
			</table>
		</center>
	</body>
</html>