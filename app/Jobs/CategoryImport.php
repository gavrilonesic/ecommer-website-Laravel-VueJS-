<?php

namespace App\Jobs;

use App\Category;
use App\File;
use App\Http\Controllers\Admin\CategoryController;
use Carbon\Carbon;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CategoryImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $file;

    public function __construct(File $file)
    {
        $this->file  = $file;
        $this->queue = 'categoryimport';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file             = $this->file;
        $file->is_working = 1;
        $file->save();

        DB::transaction(function () {
            $file              = $this->file;
            $file              = fopen($file->getMedia('file')[0]->getPath(), "r");
            $all_data          = $array          = array();
            $updateRecordCount = $newRecordCount = 0;
            $categoryList      = Category::pluck('name', 'id')->toArray();
            $categoryList      = array_map('strtolower', $categoryList);
            $i                 = $index                 = 0;
            $fields            = ['name' => 'name', 'parent_id' => "parent category", 'description' => "description", 'sort_order' => "sort order", 'page_title' => "page title", 'meta_tag_keywords' => "meta keywords", 'meta_tag_description' => 'meta description', 'image' => 'image url'];
            $array             = [];

            while (($data = fgetcsv($file, 1000, ",")) !== false) {
                $createCategory = [];
                if (!empty($data) && $i == 0) {
                    foreach ($data as $key => $value) {
                        $array[strtolower(trim($value))] = trim($key);
                    }
                } else {
                    if (isset($array['id']) && !empty($data[$array['id']])) {
                        $createCategory['id'] = $data[$array['id']];
                    }
                    foreach ($fields as $key => $value) {
                        $createCategory[$key] = $data[$array[$value]];
                        if ($key == 'parent_id' && !empty($data[$array[$value]])) {
                            $createCategory[$key] = array_search(strtolower($data[$array[$value]]), $categoryList);
                        }
                    }

                    //Get Praent category level
                    if (!empty($createCategory['parent_id'])) {
                        $parent                  = Category::find($createCategory['parent_id']);
                        $createCategory['level'] = $parent->level + 1;
                    } else {
                        $createCategory['level'] = 0;
                    }

                    // Insert or update category
                    if (!empty($createCategory['id'])) {
                        $category = Category::find($createCategory['id']);
                        if (!empty($category)) {
                            // if parent category change then current category -> child level update
                            if ($category->parent_id != $createCategory['parent_id']) {
                                CategoryController::updateChild([$category->id], $createCategory['level']);
                            }

                            $category->update($createCategory);
                            $mediaItems = $category->getMedia('category');
                        }
                    } else {
                        $category = Category::create($createCategory);
                    }

                    // Add category Image
                    try {
                        if (!empty($createCategory['image'])) {
                            $category->addMediaFromUrl(trim($createCategory['image']))->toMediaCollection('category', 'categories');
                            if (isset($mediaItems) && $mediaItems->count() > 0) {
                                $mediaItems[0]->delete();
                            }
                        }
                    } catch (Exception $e) {

                    }
                }
                $i++;
            }
            $file          = $this->file;
            $file->done_at = Carbon::now();
            $file->save();
        });

    }
}
