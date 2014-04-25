<?php
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE `{$installer->getTable('rma/request')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_email_sent` tinyint(1) NOT NULL DEFAULT '0',
  `is_submitted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{$installer->getTable('rma/items')}` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `rma_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sku_number` varchar(255) NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `descriptions` text NOT NULL,
  `serial_number` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:pending, 1:resolved,2:denied',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{$installer->getTable('rma/reason')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reason` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{$installer->getTable('rma/type')}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `{$installer->getTable('$installer->getTable('rma/emailtemplate')')}`
`template_code`,
`template_text`,
`template_styles`,
`template_type`,
`template_subject`)
VALUES
(
'RMA Confirmation',
'<body style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
    <div style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
            <tr>
                <td align=\"center\" valign=\"top\" style=\"padding: 20px 0 20px 0\">
                    <table bgcolor=\"FFFFFF\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" width=\"650\" style=\"border:1px solid #E0E0E0;\">
                        <tr>
                            <td valign=\"top\">
                                <a href=\"{{store url=\"\"}}\" style=\"color:#1E7EC8;\"><img src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/></a>
                            </td>
                        </tr>
                        <tr>
                            <td valign=\"top\">
                                <h1 style=\"font-size: 22px; font-weight: normal; line-height: 22px; margin: 0 0 15px 0;\">Dear {{var name}},</h1>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">We send You the RMA confirmation that You have requested.<br/>Please enclose a hand-copy of this when the goods are returned.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">Please notice that all parts need to be received at the return-address on the RMA confirmation, within 7 days.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If We have shipped parts in advance these will be invoice to the normal price, if the parts are not returned within the 7 day limit.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">All part's should be packed and handled like non-defective part's.<br/>So make sure to the pack parts in ESD-bags and in a box that don't break.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If the parts are returned for a credit-memo, please make sure not a write or put labels on the original box.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If You have any questions, please don't hesitate to contact us.</p>
                                <br />
                                <p style=\"font-size:12px; line-height:16px; margin: 0 0 10px 0;\">If you did not make this request, you can ignore this message.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 5px 0;\">Best regards</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0;\">RMA Department</p>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td style=\"background-color: #EAEAEA; text-align: center;\"><p style=\"font-size:12px; margin:0; text-align: center;\">Thank you, <strong>{{var store.getFrontendName()}}</strong></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>',
'body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }',
2,
'RMA Confirmation RMA{{var rmaNumber}}'
),
(
'RMA Invoice',
'<body style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\">
	<div style=\"background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;\">
		<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
<tr>
    <td align=\"center\" valign=\"top\" style=\"padding:20px 0 20px 0\">
		
		<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" height=\"100%\" width=\"100%\" style=\"max-width:785px; margin:auto; font-family:Verdana, Arial, Helvetica, sans-serif;\">
			<tr>
				<td valign=\"bottom\" style=\" font-size:14px; width:25%;\">{{var billingAddress}}</td>
				<td valign=\"bottom\" style=\"font-size:12px; font-style:italic; text-align:center; width:25%;\">{{var shippingAddress}}</td>
				<td valign=\"top\" style=\"font-size:14px; text-align:right; width:50%; padding-left:10px;\">{{var storeName}}  <br /> {{var storeAddress}} </td>
			</tr>
			
			<tr>
				<td  style=\"height:30px;\">&nbsp;</td>
				<td style=\"height:30px;\">&nbsp;</td>
				<td align=\"right\" style=\"height:10px;\">&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align=\"right\"><font style=\"font-size:18px;\">RMA bekræftelse</font> <br /> Side 1 <br /> {{var currentDate}} <br /> {{var barcodeImage}}</td>
			</tr>
			<tr style=\"font-size:14px;\">
				<td colspan=\"3\">
				<table width=\"100%;\">
				<tr>
				<td valign=\"top\" style=\"width:22%;\">Customer no<br />Fax no<br />E-mail <br /> Requisition no<br /> Reference</td>
				<td valign=\"top\" width=\"40%\">{{var customer_id}} <br />{{var fax}}<br /> {{var email}} </td>
				<td valign=\"top\">RMA no <br /> <br /> Contact Person</td>
				<td valign=\"top\" rowspan=\"2\" style=\"text-align:right; width:20%;\">
					<b>{{var rmaNumber}}</b>
					<br /> &nbsp;
					<br /> <b>{{var fullName}}</b>
				 </td>
				</tr>
				</table>
				</td>
			</tr>
			<tr>
			<td colspan=\"5\">
			<table height=\"100%\" width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
			<tr>
				<td style=\"width:10%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Type</td>
				<td style=\"width:15%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Nummer</td>
				<td style=\"width:30%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Description</td>
				<td style=\"width:10%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Qty</td>
				<td style=\"width:15%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Unit Price</td>
				<td style=\"width:15%; float:left; border-top:solid 1px #000000; border-bottom:solid 1px #000000; float:left; width:100%;  padding:4px 0; font-size:14px; font-weight:bold;\">Amount</td>
			 </tr>
			 <tr style=\"float:left; width:100%; padding:4px 0; font-size:14px;\">
				<td style=\"width:10%; float:left\">{{var returnType}}</td>
				<td style=\"width:15%; float:left\">{{var rmaId}}</td>
				<td style=\"width:30%; float:left\">{{var itemDescription}}</td>
				<td style=\"width:10%; float:left\">{{var qty}}</td>
				<td style=\"width:15%; float:left\">{{var price}}</td>
				<td style=\"width:15%; float:left\">{{var totalPrice}}</td>
			 </tr>
			</table>
			</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"height:20px;\">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan=\"5\">
					Error Description: {{var errorDescription}}
				</td>
			</tr>
			<tr>
				<td colspan=\"5\" style=\"height:60px;\">
					&nbsp;
				</td>
			</tr>
			 <tr>
				<td colspan=\"5\" style=\"text-align:center; font-size:18px;\">
						Please return to:<br />
						{{var storeName}} <br />
						{{var storeAddress}}<br />
						Att: {{var rmaNumber}}<br /><br />
						Personal callers:<br />
						{{var storeAddress}}<br /><br />
						<font style=\"font-size:16px;\">RMA Items must be returned within 7 days <br />
						from the issuance of the RMA number.</font>
				</td>
			</tr>
		</table>
	</td>
</tr>
</table>
</div>
</body>',
'body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }',
2,
'RMA Invoice'
),
(
'RMA Denied',
'<body style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
    <div style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
            <tr>
                <td align=\"center\" valign=\"top\" style=\"padding: 20px 0 20px 0\">
                    <table bgcolor=\"FFFFFF\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" width=\"650\" style=\"border:1px solid #E0E0E0;\">
                        <tr>
                            <td valign=\"top\">
                                <a href=\"{{store url=\"\"}}\" style=\"color:#1E7EC8;\"><img src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/></a>
                            </td>
                        </tr>
                        <tr>
                            <td valign=\"top\">
                                <h1 style=\"font-size: 22px; font-weight: normal; line-height: 22px; margin: 0 0 15px 0;\">Dear {{var name}},</h1>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">Your Product is not under warranty date.<br/> So we can not accept your RMA Request.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If You have any questions, please don't hesitate to contact us.</p>
                                <br />
                                <p style=\"font-size:12px; line-height:16px; margin: 0 0 10px 0;\">If you did not make this request, you can ignore this message.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 5px 0;\">Best regards</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0;\">RMA Department</p>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td style=\"background-color: #EAEAEA; text-align: center;\"><p style=\"font-size:12px; margin:0; text-align: center;\">Thank you, <strong>{{var store.getFrontendName()}}</strong></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>',
'body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }',
2,
'RMA Denied RMA{{var rmaId}}'
),
(
'Rma Request',
'<body style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
    <div style=\"background: #F6F6F6; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; margin: 0; padding: 0;\">
        <table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" height=\"100%\" width=\"100%\">
            <tr>
                <td align=\"center\" valign=\"top\" style=\"padding: 20px 0 20px 0\">
                    <table bgcolor=\"FFFFFF\" cellspacing=\"0\" cellpadding=\"10\" border=\"0\" width=\"650\" style=\"border:1px solid #E0E0E0;\">
                        <tr>
                            <td valign=\"top\">
                                <a href=\"{{store url=\"\"}}\" style=\"color:#1E7EC8;\"><img src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/></a>
                            </td>
                        </tr>
                        <tr>
                            <td valign=\"top\">
                                <h1 style=\"font-size: 22px; font-weight: normal; line-height: 22px; margin: 0 0 15px 0;\">Dear {{var name}},</h1>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">You have successfully request for RMA.<br/>Please enclose a hand-copy of this when the goods are returned.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">Please notice that all parts need to be received at the return-address on the RMA confirmation, within 7 days.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If We have shipped parts in advance these will be invoice to the normal price, if the parts are not returned within the 7 day limit.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">All part's should be packed and handled like non-defective part's.<br/>So make sure to the pack parts in ESD-bags and in a box that don't break.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If the parts are returned for a credit-memo, please make sure not a write or put labels on the original box.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 10px 0;\">If You have any questions, please don't hesitate to contact us.</p>
                                <br />
                                <p style=\"font-size:12px; line-height:16px; margin: 0 0 10px 0;\">If you did not make this request, you can ignore this message.</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0 0 5px 0;\">Best regards</p>
                                <p style=\"font-size: 12px; line-height: 16px; margin: 0;\">RMA Department</p>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td style=\"background-color: #EAEAEA; text-align: center;\"><p style=\"font-size:12px; margin:0; text-align: center;\">Thank you, <strong>{{var store.getFrontendName()}}</strong></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>',
'body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }',
2,
'Request for RMA{{var rmaId}}'
);

INSERT INTO `{$installer->getTable('$installer->getTable('rma/eavattribute')')}`
`entity_type_id`,
`attribute_code`,
`backend_type`,
`frontend_input`,
`frontend_label`,
`frontend_class`,
`is_required`,
`is_user_defined`,
`default_value`,
`is_unique`)
VALUES
(
4,
'warranty_period',
'varchar',
'text',
'Warranty Period',
'validate-digits',
1,
1,
0,
0
);
");
$installer->endSetup();
