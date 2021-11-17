<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\EmdArea;
use App\Models\SidoArea;
use App\Models\SiggArea;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        DB::table('sido_areas')->truncate();
        DB::table('sigg_areas')->truncate();
        DB::table('emd_areas')->truncate();
        DB::table('areas')->truncate();
        $geomsPath = storage_path("data/HangJeongDong_ver20210401.geojson");
        $geoms     = json_decode(file_get_contents($geomsPath), true);

        $version  = 'ver20210401';

        $sidoData = [];
        $siggData = [];
        $emdData  = [];
        $areaData = [];

        foreach ($geoms['features'] as $result) {
            $sidoAdmCode = (int)$result['properties']['sido'];
            if (!key_exists($sidoAdmCode, $sidoData)) {
                $sidoData[$sidoAdmCode] = [
                    'adm_code'   => $sidoAdmCode,
                    'name'       => $result['properties']['sidonm'],
                    'version'    => $version,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $siggData[$sidoAdmCode] = [];
            }

            $siggAdmCode = (int)$result['properties']['sgg'];
            if (!key_exists($siggAdmCode, $siggData[$sidoAdmCode])) {
                $siggData[$sidoAdmCode][$siggAdmCode] = [
                    'adm_code'   => $siggAdmCode,
                    'name'       => $result['properties']['sggnm'],
                    'version'    => $version,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $emdData[$siggAdmCode] = [];
            }

            $geom = $this->formatGeom(json_encode($result['geometry']['coordinates']));
            $emdData[$siggAdmCode][] = [
                'adm_code'   => (int) $result['properties']['adm_cd2'],
                'name'       => $result['properties']['adm_nm'],
                'geom'       => DB::raw("'MULTIPOLYGON($geom)'"),
                'location'   => DB::raw("ST_Centroid(ST_GeomFromText(('MULTIPOLYGON($geom)')))"),
                'version'    => $version,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SidoArea::insert($sidoData);
        $listSido = SidoArea::all();

        foreach ($listSido as $sido) {
            $areaData[] = [
                'original_area_id'        => $sido->id,
                'original_parent_area_id' => 0,
                'level'                   => 1,
                'name'                    => $sido->name,
                'created_at'              => now(),
                'updated_at'              => now(),
            ];

            foreach ($siggData[$sido->adm_code] as &$sigg) {
                $sigg['sido_area_id'] = $sido->id;
            }
        }

        SiggArea::insert(collect($siggData)->flatten(1)->toArray());
        $listSigg = SiggArea::all();

        foreach ($listSigg as $sigg) {
            $areaData[] = [
                'original_area_id'        => $sigg->id,
                'original_parent_area_id' => $sigg->sido_area_id,
                'level'                   => 2,
                'name'                    => $sigg->name,
                'created_at'              => now(),
                'updated_at'              => now(),
            ];

            foreach ($emdData[$sigg->adm_code] as &$emd) {
                $emd['sigg_area_id'] = $sigg->id;
            }
        }

        EmdArea::insert(collect($emdData)->flatten(1)->toArray());
        $listEmd = EmdArea::all();

        foreach ($listEmd as $emd) {
            $areaData[] = [
                'original_area_id'        => $emd->id,
                'original_parent_area_id' => $emd->sigg_area_id,
                'level'                   => 3,
                'name'                    => $emd->name,
                'created_at'              => now(),
                'updated_at'              => now(),
            ];
        }

        Area::insert($areaData);
    }

    /**
     * @param $geom
     * @return Str|null|string|string[]
     */
    public function formatGeom($geom)
    {
        $geom = Str::replace('[', '(', $geom);
        $geom = Str::replace(']', ')', $geom);
        $geom = preg_replace('/(\),)/', ');', $geom);
        $geom = Str::replace(',', ' ', $geom);
        $geom = preg_replace('/(\);)/', '),', $geom);
        $geom = Str::replace('),(', ',', $geom);
        $geom = Str::replace('))))', '))', $geom);
        $geom = Str::replace('((((', '((', $geom);

        return $geom;
    }
}
