<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadesDeMedida extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unidadesmedidas')->insert([
            ['publicId'=>'cc719852','codigo'=>'BAG','unidadMedida'=>'Bag','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc719afa','codigo'=>'BKT','unidadMedida'=>'Bucket','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc719cc6','codigo'=>'BND','unidadMedida'=>'Bundle','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc719eba','codigo'=>'BOWL','unidadMedida'=>'Bowl','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc719ff0','codigo'=>'BX','unidadMedida'=>'Box','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71a1c6','codigo'=>'CRD','unidadMedida'=>'Card','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71a36a','codigo'=>'CM','unidadMedida'=>'Centimeters','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71a536','codigo'=>'CS','unidadMedida'=>'Case','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71a66c','codigo'=>'CTN','unidadMedida'=>'Carton','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71a7de','codigo'=>'DZ','unidadMedida'=>'Dozen','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71aa86','codigo'=>'EA','unidadMedida'=>'Each','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71ac3e','codigo'=>'FT','unidadMedida'=>'Foot','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71adec','codigo'=>'GAL','unidadMedida'=>'Gallon','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71af86','codigo'=>'GROSS','unidadMedida'=>'Gross','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b0e4','codigo'=>'IN','unidadMedida'=>'Inches','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b2ce','codigo'=>'KIT','unidadMedida'=>'Kit','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b3e6','codigo'=>'LOT','unidadMedida'=>'Lot','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b648','codigo'=>'M','unidadMedida'=>'Meter','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b7ce','codigo'=>'MM','unidadMedida'=>'Millimeter','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71b95e','codigo'=>'PC','unidadMedida'=>'Piece','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71baf8','codigo'=>'PK','unidadMedida'=>'Pack','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71bcb0','codigo'=>'PK100','unidadMedida'=>'Pack 100','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71be4a','codigo'=>'PK50','unidadMedida'=>'Pack 50','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71bfc6','codigo'=>'PR','unidadMedida'=>'Pair','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c19c','codigo'=>'RACK','unidadMedida'=>'Rack','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c2f0','codigo'=>'RL','unidadMedida'=>'Roll','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c4c6','codigo'=>'SET','unidadMedida'=>'Set','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c692','codigo'=>'SET3','unidadMedida'=>'Set of 3','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c822','codigo'=>'SET4','unidadMedida'=>'Set of 4','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71c99e','codigo'=>'SET5','unidadMedida'=>'Set of 5','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71cb88','codigo'=>'SGL','unidadMedida'=>'Single','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71cd5e','codigo'=>'SHT','unidadMedida'=>'Sheet','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71cf5c','codigo'=>'SQFT','unidadMedida'=>'Square ft','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71d164','codigo'=>'TUBE','unidadMedida'=>'Tube','created_at'=>new \DateTime('now')],
            ['publicId'=>'cc71d33a','codigo'=>'YD','unidadMedida'=>'Yard','created_at'=>new \DateTime('now')],
            ['publicId'=>'cbd42dc4','codigo'=>'KM','unidadMedida'=>'Kilometers','created_at'=>new \DateTime('now')],
            ['publicId'=>'cbd42f40','codigo'=>'GR','unidadMedida'=>'Grams','created_at'=>new \DateTime('now')],
            ['publicId'=>'cbd4306c','codigo'=>'KG','unidadMedida'=>'Kilograms','created_at'=>new \DateTime('now')],
        ]);
    }
}
