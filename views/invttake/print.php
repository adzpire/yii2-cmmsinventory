<?php
//use Yii;
use yii\helpers\Html;

$checkedbox = '<img width="16" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjwhRE9DVFlQRSBzdmcgIFBVQkxJQyAnLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4nICAnaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkJz48c3ZnIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDMyIDMyIiBoZWlnaHQ9IjMycHgiIGlkPSLQodC70L7QuV8xIiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMycHgiIHhtbDpzcGFjZT0icHJlc2VydmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiPjxnIGlkPSJDaGVja19TcXVhcmUiPjxwYXRoIGQ9Ik0zMCwwSDJDMC44OTUsMCwwLDAuODk1LDAsMnYyOGMwLDEuMTA1LDAuODk1LDIsMiwyaDI4YzEuMTA0LDAsMi0wLjg5NSwyLTJWMkMzMiwwLjg5NSwzMS4xMDQsMCwzMCwweiAgICBNMzAsMzBIMlYyaDI4VjMweiIgZmlsbD0iIzEyMTMxMyIvPjxwYXRoIGQ9Ik0xMi4zMDEsMjIuNjA3YzAuMzgyLDAuMzc5LDEuMDQ0LDAuMzg0LDEuNDI5LDBsMTAuOTk5LTEwLjg5OWMwLjM5NC0wLjM5LDAuMzk0LTEuMDI0LDAtMS40MTQgICBjLTAuMzk0LTAuMzkxLTEuMDM0LTAuMzkxLTEuNDI4LDBMMTMuMDExLDIwLjQ4OGwtNC4yODEtNC4xOTZjLTAuMzk0LTAuMzkxLTEuMDM0LTAuMzkxLTEuNDI4LDBjLTAuMzk1LDAuMzkxLTAuMzk1LDEuMDI0LDAsMS40MTQgICBMMTIuMzAxLDIyLjYwN3oiIGZpbGw9IiMxMjEzMTMiLz48L2c+PGcvPjxnLz48Zy8+PGcvPjxnLz48Zy8+PC9zdmc+" >';
$uncheckbox = '<img width="16" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAHUlEQVQ4jWNgYGD4TyGGEGSCUQNGDRg1gNoGkI0BF6E7xdLOry8AAAAASUVORK5CYII=" >';
?>

<body>
<div align="center">
    <table  align="center" width="650" border="0" style="background-color:#fff;">
        <tr>
            <td colspan="2" class="tbhead" align="center">
                <p><strong>ใบเบิกครุภัณฑ์ทุกชนิดจากงานพัสดุ</strong></p>
                <p><strong>คณะวิทยาการสื่อสาร</strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tbhead" align="right">
                <p>วันที่ ...<u><?php echo \Yii::$app->formatter->asDate($model->date, "long"); ?></u>....</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tbhead" align="left">
                <p><strong>เรียน หัวหน้างานพัสดุ</strong></p>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้า .....<u><?php echo $model->staff->getFullname('th'); ?></u>
                    ... ตำแหน่ง ...<u><?php echo $model->staff->position->name_th; ?></u>.....</p>
                <p>มีความประสงค์จะขอเบิกครุภัณฑ์ตามรายการข้างล่างนี้เพื่อนำไปใช้ประจำที่ ...<u><?php echo $model->location->loc_name ?></u>....</p>
            </td>
        </tr>
    </table>
    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <th>
            <tr>
                <td>ลำดับที่</td>
                <td align="center">รายการ</td>
                <td align="center">เลขครุภัณฑ์</td>
                <td align="center">ราคา</td>
                <td align="center">ครอบครองโดย</td>
            </tr>
        </th>
        <?php
        $count = 1;
        foreach ($detailmdl as $row) {
            echo '<tr>';
            echo '<td width="31" scope="col" align="center">' . $count . '</td>';
            echo '<td scope="col">' . $row->invt->shortdetail . '</td>';
            echo '<td scope="col">' . $row->invt->invt_code . '</td>';
            echo '<td scope="col">' . $row->invt->invt_ppp . '</td>';
            echo '<td>' . $row->invt->invt_occupyby . '</td>';

            echo '</tr>';
            $count++;
        }
        ?>

    </table>
    <table width="100%">
        <tr>
            <td colspan="2">
                ข้าพเจ้าขอรับรองว่าครุภัณฑ์ขอเบิกไปนี้จะนำไปใช้ในงานราชการเท่านั้น
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>(ลงชื่อ) ....................................... ผู้ขอเบิก</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>(...<u><?php echo $model->staff->getFullname('th'); ?></u>...)</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
        <tr>
            <td width="319" class="tbcontent">
                <strong>เรียน หัวหน้างานพัสดุ</strong><br />
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพื่อโปรดพิจารณา .............................................................</p>
                <p>...................................................................................................</p>
                <p>...................................................................................................</p>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>(ลงชื่อ) ....................................... เจ้าหน้าที่พัสดุ</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>(...<u>นางยุพดี อุดมพงษ์</u>...)</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td align="center"  width="319" class="tbcontent">
                <p align="center"><strong>ความเห็นหัวหน้างานพัสดุ</strong></p>
                <p>...................................................................................................</p>
                <p>...................................................................................................</p>
                <p>...................................................................................................</p>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>(ลงชื่อ) ......................................... หัวหน้างานพัสดุ</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>( ...<u>นางแก่นจันทร์ มูสิกธรรม</u>... )</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="tbcontent">
                <p><strong>ข้าพเจ้าได้จ่ายของครบถ้วนตามรายการที่ได้ขอเบิก</strong></p>

                <table align="center">
                    <tr>
                        <td>
                            (ลงชื่อ) .............................................. ผู้จ่ายของ
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            ( ...<u>นางยุพดี อุดมพงษ์</u>... )
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>วันที่ ............................................. </p>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="tbcontent">
                <p><strong>ข้าพเจ้าได้ตรวจรับครภัณฑ์ที่ขอเบิกครบถ้วนแล้ว</strong></p>

                <table align="center">
                    <tr>
                        <td>
                            (ลงชื่อ) .............................................. ผู้รับของ
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            ( ...<u><?php echo $model->staff->getFullname('th'); ?></u>... )
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>วันที่ ............................................. </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>