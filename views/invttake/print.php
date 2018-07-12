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
            <td colspan="2" class="tbhead" align="right">
                <p><strong>แบบ กทพ. 01</strong></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tbhead" align="center">
                <p><strong>ใบเบิกเงินสวัสดิการเกี่ยวกับการรักษาพยาบาลพนักงานมหาวิทยาลัย</strong></p>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td colspan="2">

                <p>ข้าพเจ้า .....<u><?php echo $model->mfSt->getFullname('th'); ?></u>
                    ... ตำแหน่ง ...<u><?php echo $model->mfSt->position->name_th; ?></u>.....</p>
                <p>สังกัด .....<u>คณะวิทยาการสื่อสาร</u>..... &nbsp;&nbsp;&nbsp; โทรศัพท์
                .....<u><?php echo $intmdl->number; ?></u>.....</p>
                <p>ป่วยเป็นโรค ...<u><?php echo $model->mf_ill; ?></u>... สถานพยาบาลที่เข้ารับการรักษา ...<u><?php echo $model->mf_hospital; ?></u>...</p>
                <p>ขอเบิกเงินจำนวน ...<u><?php echo number_format($model->mf_want,2,'.',','); ?></u>... บาท
                    &nbsp;( ...<u><?php echo $thaibathtext; ?></u>... ) เพื่อเป็น
                </p>
                <br>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($model->mf_choice < '3'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;ค่ารักษาพยาบาล ค่าคลอดบุตรและทันตกรรม</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if($model->mf_choice == '1'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;ตนเอง&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php if($model->mf_choice == '2'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;ญาติสายตรง (บิดา มารดา คู่สมรส และบุตร ของข้าพเจ้า)
                </p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($model->mf_choice == '3'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;<?php echo $model->choice[3]; ?></p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($model->mf_choice == '4'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;เบิกจ่ายส่วนที่เกินโดยจ่ายร่วมมหาวิทยาลัย(Co-pay) เฉพาะค่าวัสดุอุปกรณ์ทางการแพทย์ และอวัยวะเทียม</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($model->mf_choice == '5'){echo $checkedbox;}else echo $uncheckbox; ?>&nbsp;&nbsp;&nbsp;<?php echo $model->choice[5]; ?></p>
                <br>
                <p>เอกสารแนบประกอบการขอเบิก</p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $checkedbox; ?>  ใบเสร็จ และ ใบรับรองแพทย์</p>
                <p>&nbsp;</p>
            </td>
        </tr>
        <tr>
            <td align="center" width="319" class="tbcontent">
                ข้าพเจ้าขอรับรองว่าข้อความข้างต้นเป็นจริงทุกประการ<br />
                <table align="center">
                    <tr>
                        <td>
                            <p>(ลงชื่อ) ....................................... ผู้ขอรับเงิน</p>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>(...........................................)</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>วันที่ ...........................................</p>
                        </td>
                    </tr>
                </table>
            </td>
            <td align="center"  width="319" class="tbcontent">
                <p align="center"><strong>อนุมัติให้เบิกจ่ายได้</strong></p>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>(ลงชื่อ) .........................................</p>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>
                <table align="center">
                    <tr>
                        <td>
                            <p>( ........................................................ )</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>ตำแหน่ง ........................................</p>
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            <p>วันที่ ...........................................</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="tbcontent">
                <table align="center">
                    <tr>
                        <td><strong>ใบรับเงิน</strong></td>
                    </tr>
                </table>
                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ข้าพเจ้าได้รับเงินสวัสดิการเกี่ยวกับการรักษาพยาบาล จำนวน ...<u><?php echo number_format($model->mf_want,2,'.',','); ?></u>... บาท<br />
                    &nbsp;&nbsp;&nbsp;&nbsp;( ...<u><?php echo $thaibathtext; ?></u>... ) ไปถูกต้องแล้ว
                </p>
                <table align="center">
                    <tr>
                        <td>
                            (ลงชื่อ) .............................................. ผู้รับเงิน
                        </td>
                    </tr>
                </table>
                <table align="center">
                    <tr>
                        <td>
                            ( ..................................................... )
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