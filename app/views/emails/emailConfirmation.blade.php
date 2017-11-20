@include('emails.header')
															<table cellpadding="0" cellspacing="0" style="width:580px;border-collapse:collapse;table-layout:fixed;background:#FFFFFF;">
																<tbody>
																	<tr>
																		<td width="100%" style="vertical-align:top;">
																			<div>
																				<table style="width:100%;border-collapse:separate;table-layout:fixed;background:#FFFFFF;" cellspacing="15" cellpadding="0">
																					<tbody>
																						<tr>
																							<td style="background:#FFFFFF;">
																								<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0px;table-layout:fixed;">
																									<tbody>
																										<tr>
																											<td style="vertical-align:top;">
																												<div style="word-wrap:break-word;line-height:140%;text-align:left;">
																													<p>
																														<br>
																														<span style="font-size:14px;">Dear {{$name}},<br>
																														&nbsp;<br>
																														Thanks for checking out [[companyname]].</span><br>
																														<br>
																														<span style="font-size:14px">Thanks for signing up for [[companyname]]! We know it&#8217;s going to make your business more enjoyable for both you and your customers&nbsp;</span><br>
																														<br>
																														<span style="font-size:14px"><em><a href="<?php echo Config::get('app.url'); ?>verify-email?code={{$code}}">CLICK HERE</a> to verify your email and complete your registration to [[companyname]].</em><br>
																														<br>
																														<span style="font-size:12px;">If you&#8217;d like, you can also return to the registration page and enter the following code: {{$code}}</span><br>
																														<br>
																														<span style="font-size:14px;">If you&#8217;re interested in some tips to optimize your [[companyname]] experience, check out our <a href="http://bit.ly/[[companyname]]-tips" target="_blank" style="color: #00aeb3; text-decoration: none;">Rock Your [[companyname]] Tipsheet</a>.<br><br></span>
																														Thanks for checking us out!,<br>
																														<br>
																														Your Friends at [[companyname]]<br>
																														<br></span>
																													</p>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			<div>
																				<table style="border-collapse:separate;border-spacing:0px;table-layout:fixed;" cellpadding="5" cellspacing="5">
																					<tbody>
																						<tr>
																							<td></td>
																						</tr>
																					</tbody>
																				</table>
																				<table style="width:100%;border-collapse:separate;table-layout:fixed;background:#FFFFFF;" cellspacing="15" cellpadding="0">
																					<tbody>
																						<tr>
																							<td style="background:#FFFFFF;">
																								<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0px;table-layout:fixed;">
																									<tbody>
																										<tr>
																											<td width="149" style="vertical-align:top;text-align:left;" align="left">
																												<div style="border-right-width:12px;border-right-style:solid;border-right-color:#FFFFFF;">
																													<a href="[[company-url]]" style="width:auto;" target="_blank"><img style="border:medium" width="150" height="61" src="http://demo.geekslabs.com/materialize/v2.2/layout03/images/generic-logo.png"></a>
																												</div>
																											</td>
																											<td style="vertical-align:top;">
																												<div style="word-wrap:break-word;line-height:140%;text-align:left;"></div>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			<div>
																				<table style="border-collapse:separate;border-spacing:0px;table-layout:fixed;" cellpadding="5" cellspacing="5">
																					<tbody>
																						<tr>
																							<td></td>
																						</tr>
																					</tbody>
																				</table>
																				<table style="width:100%;border-collapse:separate;table-layout:fixed;" cellspacing="0" cellpadding="0">
																					<tbody>
																						<tr>
																							<td style="background:#ffffcf;">
																								<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0px;table-layout:fixed;">
																									<tbody>
																										<tr>
																											<td style="vertical-align:middle;padding-top:10px;padding-bottom:10px;padding-left:0;padding-right:0;">
																												<div style="word-wrap:break-word;line-height:140%;text-align:left;">
																													<p style="text-align:center;font-size:11px;margin:0;">
																														Email not displaying correctly? <a href="[[email-web-url]]" style="text-decoration:none;"><span style="text-decoration:underline;color:#002AFF;">View it</span></a> in your browser
																													</p>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																			<div>
																				<table style="border-collapse:separate;border-spacing:0px;table-layout:fixed;" cellpadding="5" cellspacing="5">
																					<tbody>
																						<tr>
																							<td></td>
																						</tr>
																					</tbody>
																				</table>
																				<table style="width:100%;border-collapse:separate;table-layout:fixed;background:#f1f1f1;" cellspacing="15" cellpadding="0">
																					<tbody>
																						<tr>
																							<td style="background:#f1f1f1;">
																								<table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:separate;border-spacing:0px;table-layout:fixed;">
																									<tbody>
																										<tr>
																											<td style="vertical-align:middle;font-size:11px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
																												<div style="word-wrap:break-word;line-height:140%;text-align:left;">
																													<p style="font-size:11px;margin:0px;text-align:left;">
																														To unsubscribe please click <a style="text-decoration:none;" href="[[unsubcribe-url]]"><span style="color:#0000FF;text-decoration:underline;">here</span></a>
																													</p>
																												</div>
																											</td>
																											<td style="vertical-align:middle;font-size:11px;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;">
																												<div style="word-wrap:break-word;line-height:140%;text-align:left;">
																													<p style="font-size:11px;margin:0px;text-align:left;">
																														&copy; [[companyname]] Corporation, [[company-address]]. [[companyname]] and the [[companyname]] logo are registered trademarks of [[companyname]].
																													</p>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</div>
																		</td>
																	</tr>
																</tbody>
															</table>
@include('emails.footer')
