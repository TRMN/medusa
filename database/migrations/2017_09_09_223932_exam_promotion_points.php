<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExamPromotionPoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = [
          2 => [
            '/(?>SIA|KR1MA|IMNA|PAA|LU)-(?>RMN|RMMC|RMA|GSN|IAN|RMMM|RMACS|CORE|KC|QC)-(?>0001|0011|0101|01)/',
            '/(?>SIA|IMNA)-(?>RMN|RMMC|GSN|RMACS)-(?>0006|0013|0106)/',
            '/KR1MA-RMA-(?>0008|0014|0104)/',
            '/SIA-RMMM-0005/',
            '/LU-(?>KC|QC)-(?>0006|0013|0105)/',
            '/(?>SIA|LU)-(?>RMN|RMMC|KC|QC)-(?>0113|0115)/',
            '/SIA-(?>RMN|RMMC)-[0-9][1-9][WD]/',
            '/IMNA-(?>AFLTC|GTSC)-[0-9][1-9][MD]/',
            '/(?>LU|MU)-(?>CRIM|XI|ECON|HS19C|HS20C|HSAFR|HSASN|HSEUR|HSMED|HSNAM|HSTRM|PLSC)-(?>03|04|CZ03|CZ04|XA03|XS04|XB03|XB04)/',
          ],
          3 => [
            '/(?>SIA|LU)-(?>RMN|RMMC|RMASC|KC|QC)-(?>1001|1002|1003|1004|1005|2001)/',
          ],
          4 => [
            '/SIA-(?>RMN|RMMC)-1005/',
          ],
          5 => [
            '/SIA-RMN-2001S/',
          ]
        ];

        \App\MedusaConfig::set('pp.exams', $config);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\MedusaConfig::remove('pp.exams');
    }
}
