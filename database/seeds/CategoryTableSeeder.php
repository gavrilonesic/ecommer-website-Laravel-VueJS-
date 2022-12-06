<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //parent 0
        collect([
            ['name' => 'CAR CARE'],
            ['name' => 'CARPET CLEANING'],
            ['name' => 'DECK & PAVER'],
            ['name' => 'FOUNDRY'],
            ['name' => 'PAINT BOOTH MAINTENANCE'],
            ['name' => 'PAINT STRIPPERS'],
            ['name' => 'STRIPPABLE COATINGS'],
            ['name' => 'VANISHING OIL'],
            ['name' => 'LUBRICANTS'],
            ['name' => 'SOLDERING FLUXES'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 0;
            $item['level']  = 0;
            Category::create($item);
        });
        // parent 1
        collect([
            ['name' => 'Glass Cleaner','template_layout'=>'category_with_compare_products'],
            ['name' => 'Exterior','template_layout'=>'category_with_compare_products'],
            ['name' => 'Peelable Coatings','template_layout'=>'category_with_compare_products'],
            ['name' => 'Wheels & Rims','template_layout'=>'category_with_compare_products'],
            ['name' => 'Degreasers','template_layout'=>'category_with_compare_products'],
            ['name' => 'Interior','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 1;
            $item['level']  = 1;
            Category::create($item);
        });
        // parent 2
        collect([
            ['name' => 'Fabric Rinses','template_layout'=>'category_with_product'],
            ['name' => 'Defoamer','template_layout'=>'category_with_product'],
            ['name' => 'Shampoos & Detergents','template_layout'=>'category_with_product'],
            ['name' => 'Deodorizers & Neutralizers','template_layout'=>'category_with_product'],
            ['name' => 'Stain Removers'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 2;
            $item['level']  = 1;
            Category::create($item);
        });
        // parent 3
        collect([
            ['name' => 'Deck Cleaners','template_layout'=>'category_with_compare_products'],
            ['name' => 'Deck Brighteners','template_layout'=>'category_with_compare_products'],
            ['name' => 'Deck Strippers','template_layout'=>'category_with_compare_products'],
            ['name' => 'Deck Restorer','template_layout'=>'category_with_compare_products'],
            ['name' => 'Down Stream Injectables','template_layout'=>'category_with_compare_products'],
            ['name' => 'Masonry Cleaner','template_layout'=>'category_with_compare_products'],
            ['name' => 'Paver Sealer','template_layout'=>'category_with_compare_products'],
            ['name' => 'Vinyl Siding Cleaner','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 3;
            $item['level']  = 1;
            Category::create($item);
        });
        // parent 4
        collect([
            ['name' => 'COLD BOX MOLD RELEASE AGENTS','template_layout'=>'category_with_compare_products'],
            ['name' => 'GREEN SAND PARTINGS','template_layout'=>'category_with_compare_products'],
            ['name' => 'METAL CLEANERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'PATTERN SPRAYS','template_layout'=>'category_with_compare_products'],
            ['name' => 'WARM OR SHELL BOX MOLD RELEASE AGENTS','template_layout'=>'category_with_compare_products'],
            ['name' => 'CORE PASTES & HOT SHELL ADHESIVES','template_layout'=>'category_with_compare_products'],
            ['name' => 'IMMERSION CLEANERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'MUDDING COMPOUNDS','template_layout'=>'category_with_compare_products'],
            ['name' => 'SAND TREATMENT','template_layout'=>'category_with_compare_products'],
            ['name' => 'CORROSION INHIBITORS','template_layout'=>'category_with_compare_products'],
            ['name' => 'INVESTMENT CASTING','template_layout'=>'category_with_compare_products'],
            ['name' => 'NO BAKE MOLD RELEASE AGENTS','template_layout'=>'category_with_compare_products'],
            ['name' => 'STEAMCLEANER'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 4;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 5
        collect([
            ['name' => 'BOOTH GREASES','template_layout'=>'category_with_compare_products'],
            ['name' => 'PROTECTIVE BOOTH COATINGS','template_layout'=>'category_with_compare_products'],
            ['name' => 'TACKY BOOTH COATINGS','template_layout'=>'category_with_compare_products'],
            ['name' => 'E-COAT CLEANERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'THICKENED PAINT STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'PAINT BOOTH CLEANING','template_layout'=>'category_with_compare_products'],
            ['name' => 'OVEN CLEANERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'PAINT LINE CLEANERS','template_layout'=>'category_with_compare_products'],
            ['name' => 'PEELABLE BOOTH COATING','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 5;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 6
        collect([
            ['name'=>'ALUMINUM PAINT STRIPPER','template_layout'=>'category_with_compare_products'],
            ['name'=>'EPOXY PAINT STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'GRAFFITI REMOVERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'OXYSTRIP'],
            ['name'=>'WOOD PAINT STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'CONTAINER CLEANING','template_layout'=>'category_with_compare_products'],
            ['name'=>'FLOOR PAINT STRIPPING','template_layout'=>'category_with_compare_products'],
            ['name'=>'LATEX RESIN REMOVER','template_layout'=>'category_with_compare_products'],
            ['name'=>'POWDER COATING STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'E-COAT STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'GALVANIZED & ZINC DIE CAST PAINT STRIPPERS','template_layout'=>'category_with_compare_products'],
            ['name'=>'LEATHER PROCESSING','template_layout'=>'category_with_compare_products'],
            ['name'=>'URETHANE PAINT STRIPPERS','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 6;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 7
        collect([
            ['name'=>'aerospace','template_layout'=>'category_with_compare_products'],
            ['name'=>'automotive','template_layout'=>'category_with_compare_products'],
            ['name'=>'marine','template_layout'=>'category_with_compare_products'],
            ['name'=>'coating remover','template_layout'=>'category_with_compare_products'],
            ['name'=>'construction','template_layout'=>'category_with_compare_products'],
            ['name'=>'decontamination','template_layout'=>'category_with_compare_products'],
            ['name'=>'equipment','template_layout'=>'category_with_compare_products'],
            ['name'=>'floor','template_layout'=>'category_with_compare_products'],
            ['name'=>'furniture','template_layout'=>'category_with_compare_products'],
            ['name'=>'glow in the dark','template_layout'=>'category_with_compare_products'],
            ['name'=>'high temp','template_layout'=>'category_with_compare_products'],
            ['name'=>'chemical milling','template_layout'=>'category_with_compare_products'],
            ['name'=>'laser engraving','template_layout'=>'category_with_compare_products'],
            ['name'=>'metal','template_layout'=>'category_with_compare_products'],
            ['name'=>'optical','template_layout'=>'category_with_compare_products'],
            ['name'=>'paint spray booths','template_layout'=>'category_with_compare_products'],
            ['name'=>'liquid masking','template_layout'=>'category_with_compare_products'],
            ['name'=>'screen printing','template_layout'=>'category_with_compare_products'],
            ['name'=>'solvent','template_layout'=>'category_with_compare_products'],
            ['name'=>'stone','template_layout'=>'category_with_compare_products'],
            ['name'=>'Tv & Movie Studio','template_layout'=>'category_with_compare_products'],
            ['name'=>'window','template_layout'=>'category_with_compare_products'],
            ['name'=>'UV','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 7;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 8
        collect([
            ['name'=>'High Performance Vanishing Oil','template_layout'=>'category_with_compare_products'],
            ['name'=>'High Speed Vanishing Oil','template_layout'=>'category_with_compare_products'],
            ['name'=>'Soluble Total Dry Fim Vanishing Oil','template_layout'=>'category_with_compare_products'],
            ['name'=>'Solvent-Based Vanishing Oil','template_layout'=>'category_with_compare_products'],
            ['name'=>'Thermal Vanishing Oil','template_layout'=>'category_with_compare_products'],
            ['name'=>'Vanishing Oils'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 8;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 9
        collect([
            ['name'=>'Aluminum Processing','template_layout'=>'category_with_compare_products'],
            ['name'=>'Copper Brass Processing','template_layout'=>'category_with_compare_products'],
            ['name'=>'Corrosion Inhibitors','template_layout'=>'category_with_compare_products'],
            ['name'=>'Metal Cleaning','template_layout'=>'category_with_compare_products'],
            ['name'=>'Metal Polishes','template_layout'=>'category_with_compare_products'],
            ['name'=>'Oil Based Lubricants','template_layout'=>'category_with_compare_products'],
            ['name'=>'Rolling Mill Lubricants','template_layout'=>'category_with_compare_products'],
            ['name'=>'Soluble Oils'],
            ['name'=>'Synthetic Lubricants'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 9;
            $item['level']  = 1;
            Category::create($item);
        });

        // parent 10
        collect([
            ['name'=>'ALUMINUM PROCESSING','template_layout'=>'category_with_compare_products'],
            ['name'=>'METAL LUBRICANT','template_layout'=>'category_with_compare_products'],
            ['name'=>'CAST ON STRAP BATTERY','template_layout'=>'category_with_compare_products'],
            ['name'=>'ROLLING MILL','template_layout'=>'category_with_compare_products'],
            ['name'=>'COPPER BRASS PROCESSING','template_layout'=>'category_with_compare_products'],
            // ['name'=>'SOLDERING FLUXES','template_layout'=>'category_with_compare_products'],
        ])->each(function ($item, $key) {
            $item['name']       = ucwords(strtolower($item['name']));
            $item['page_title'] = ucwords(strtolower($item['name']));
            $item['parent_id']  = 10;
            $item['level']  = 1;
            Category::create($item);
        });
    }
}
