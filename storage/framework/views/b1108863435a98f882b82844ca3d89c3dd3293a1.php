<html>
    <head>
        <meta charset="UTF-8" />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="x-apple-disable-message-reformatting" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta content="telephone=no" name="format-detection" />
        <title></title>
        <style>
            @import  url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800");
            * {
                font-family: "Open Sans", sans-serif;
            }
        </style>
    </head>

    <body>
        <div class="es-wrapper-color">
            <table cellpadding="0" cellspacing="0" class="es-wrapper" width="100%">
                <tbody>
                    <tr>
                        <td valign="top" class="esd-email-paddings">
                            <table cellpadding="0" cellspacing="0" class="es-header esd-header-popover" align="center" style="border:1px solid #ccc;  padding: 15px;">
                                <tbody>
                                    <tr>
                                        <td class="esd-stripe" align="center">
                                            <table class="es-header-body" align="center" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td class="esd-structure es-p20b es-p20r es-p20l" align="left"
                                                            style="background-position: center top; background-color: rgb(255, 255, 255);"
                                                            bgcolor="#ffffff">
                                                            <table cellpadding="0" cellspacing="0" width="100%" >
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="560" class="esd-container-frame" align="center" valign="top" >
                                                                            <table cellpadding="0" cellspacing="0" width="100%" >
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" class="esd-block-image">
                                                                                            <a href="#" target="_blank">
                                                                                                <img src="<?php echo e(asset('images/logo.png'), false); ?>" alt="" width="" style="display: block; margin-top: 20px;" />
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td align="center" class="esd-block-image" >
                                                                                            <div style="padding: 20px 0; background-color:#f8f8f8; margin-top: 30px; padding: 20px;">
                                                                                                <table cellpadding="8" cellspacing="4">
                                                                                                    <tr>
                                                                                                        <td><strong>Department</strong></td>
                                                                                                        <td><?php echo e($department['name_en'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Doctor Name</strong></td>
                                                                                                        <td><?php echo e($doctor['prefix_en'], false); ?> <?php echo e($doctor['name_en'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Name</strong></td>
                                                                                                        <td><?php echo e($appointment['name'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Phone Number</strong></td>
                                                                                                        <td><?php echo e($appointment['phone_number'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Civil Id </strong></td>
                                                                                                        <td><?php echo e($appointment['civil_id'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Preffered Date & Time </strong></td>
                                                                                                        <td><?php echo e($appointment['preffered_date'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td><strong>Email Id</strong></td>
                                                                                                        <td><?php echo e($appointment['email'], false); ?></td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td colspan="2">
                                                                                                            <strong>Message</strong>
                                                                                                            <p style="margin: 0"><?php echo e($appointment['message'], false); ?></p>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </table>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table cellpadding="0" cellspacing="0" class="esd-footer-popover es-content" align="center" style="background: #026f78; padding: 30px 15px;">
                                <tbody>
                                    <tr>
                                        <td class="esd-stripe" align="center">
                                            <table class="es-content-body" align="center" cellpadding="0" cellspacing="0" width="600" style="background-color: transparent;">
                                                <tbody>
                                                    <tr>
                                                        <td class="esd-structure es-p30t es-p30b es-p20r es-p20l" align="left">
                                                            <table cellpadding="0" cellspacing="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td width="" class="esd-container-frame" align="center" style="width:50%; padding-left: 20px;" valign="top">
                                                                        
                                                                        </td>
                                                                        <td width="" class="esd-container-frame" align="center" valign="top">
                                                                        
                                                                        </td>   
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
