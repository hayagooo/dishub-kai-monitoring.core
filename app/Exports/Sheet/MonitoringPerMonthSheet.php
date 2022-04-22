<?php

namespace App\Exports\Sheet;

use App\Models\Monitoring\Category;
use App\Models\Monitoring\Input;
use App\Models\Monitoring\InputValue;
use App\Models\Monitoring\Monitoring;
use App\Models\Monitoring\ObjectData;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MonitoringPerMonthSheet implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithMapping
{
    private $year;
    public $category_id;
    public $object_id;

    public function __construct(mixed $year, mixed $category_id, mixed $object_id)
    {
        $this->year = $year;
        $this->category_id = $category_id;
        $this->object_id = $object_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Monitoring::query()->with('input', 'input.option', 'input.valueData', 'team', 'employee', 'object', 'category')->whereYear('created_at', $this->year)->get();
    }

    public function map($monitoring): array
    {
        $data_entity = [
            $monitoring->title ? $monitoring->title : '-',
            $monitoring->category->name ? $monitoring->category->name : '-',
            $monitoring->object->name ? $monitoring->object->name : '-',
            Carbon::make($monitoring->created_at)->format('l, j F Y, H:i'),
            $monitoring->description ? strip_tags($monitoring->description) : '-',
            $monitoring->employee->name ? $monitoring->employee->name : '-',
            $monitoring->team->name ? $monitoring->team->name : '-',
        ];
        $inputs_arr = [];
        $nonInputValue = ['image', 'description', 'media-youtube', 'file'];
        $category = Category::with(['input' => function($query) {
            $query->where('monitoring_category_id', $this->category_id)
                ->where('monitoring_object_id', null);
        }, 'input.valueData' => function($query) use($monitoring) {
            $query->where('monitoring_id', $monitoring->id);
        }, 'monitoring'])->whereHas('monitoring', function($query) use($monitoring) {
            $query->where('id', $monitoring->id);
        })->first();
        foreach($category->input as $input) {
            if(!in_array($input->type, $nonInputValue, true)) {
                $value = InputValue::query()->with(['monitoring', 'input', 'input.option' => function($query) use($input) {
                    $query->where('monitoring_input_id', $input->id);
                }])
                ->where('monitoring_input_id', $input->id)
                ->where('monitoring_id', $monitoring->id)
                ->whereHas('input', function($query) {
                    $query->where('monitoring_object_id', null);
                })->first();
                if($value != null) {
                    if($input->type == 'text')
                        $inputs_arr[] = !is_null($value->string_value) ? $value->string_value : '-';
                    if($input->type == 'textarea')
                        $inputs_arr[] = !is_null($value->text_value) ? strip_tags($value->text_value) : '-';
                    if($input->type == 'number')
                        $inputs_arr[] = !is_null($value->number_value) ? $value->number_value : '-';
                    if($input->type == 'date')
                        $inputs_arr[] = !is_null($value->date_value) ? $value->date_value : '-';
                    if($input->type == 'time')
                        $inputs_arr[] = !is_null($value->time_value) ? $value->time_value : '-';
                    if($input->type == 'checkbox') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->monitoring_input_id == $input->id) {
                                if($option->is_checked == 1)
                                    $option_value .= $option->value.' ,';
                            }
                        }
                        $option_value .= !is_null($value->string_value) ? $value->string_value : '';
                        $inputs_arr[] = $option_value;
                    }
                } else {
                    if($input->type == 'checkbox') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->monitoring_input_id == $input->id) {
                                if($option->is_checked == 1)
                                    $option_value .= $option->value.' ,';
                            }
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else if($input->type == 'radio') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->monitoring_input_id == $input->id) {
                                if($option->is_checked == 1)
                                    $option_value .= $option->value.' ,';
                            }
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else if($input->type == 'dropdown') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->monitoring_input_id == $input->id) {
                                if($option->is_checked == 1)
                                    $option_value .= $option->value.' ,';
                            }
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else
                        $inputs_arr[] = '-';
                }
            }
        }

        $object_data = ObjectData::with(['input' => function($query) {
            $query->where('monitoring_category_id', $this->category_id)
                ->where('monitoring_object_id', $this->object_id)
                ->where('monitoring_id', null);
        }, 'input.valueData' => function($query) use($monitoring) {
            $query->where('monitoring_id', $monitoring->id);
        }, 'monitoring'])->whereHas('monitoring', function($query) use($monitoring) {
            $query->where('id', $monitoring->id);
        })->first();

        foreach($object_data->input as $input) {
            if(!in_array($input->type, $nonInputValue, true)) {
                $value = InputValue::query()->with('monitoring', 'input', 'input.option')
                ->where('monitoring_input_id', $input->id)
                ->where('monitoring_id', $monitoring->id)
                ->whereHas('input', function($query) use($object_data) {
                    $query->where('monitoring_object_id', $object_data->id)->where('monitoring_id', null);
                })->first();
                if($value != null) {
                    if($input->type == 'text')
                        $inputs_arr[] = !is_null($value->string_value) ? $value->string_value : '-';
                    if($input->type == 'textarea')
                        $inputs_arr[] = !is_null($value->text_value) ? strip_tags($value->text_value) : '-';
                    if($input->type == 'number')
                        $inputs_arr[] = !is_null($value->number_value) ? $value->number_value : '-';
                    if($input->type == 'date')
                        $inputs_arr[] = !is_null($value->date_value) ? $value->date_value : '-';
                    if($input->type == 'time')
                        $inputs_arr[] = !is_null($value->time_value) ? $value->time_value : '-';
                    if($input->type == 'checkbox') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->is_checked == 1)
                                $option_value .= $option->value.' ,';
                        }
                        $option_value .= !is_null($value->string_value) ? $value->string_value : '';
                        $inputs_arr[] = $option_value;
                    }
                } else {
                    if($input->type == 'checkbox') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->is_checked == 1)
                                $option_value .= $option->value.' ,';
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else if($input->type == 'radio') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->is_checked == 1)
                                $option_value .= $option->value.' ,';
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else if($input->type == 'dropdown') {
                        $option_value = '';
                        foreach($input->option as $option) {
                            if($option->is_checked == 1)
                                $option_value .= $option->value.' ,';
                        }
                        $inputs_arr[] = $option_value;
                    }
                    else
                        $inputs_arr[] = '-';
                }
            }
        }

        $monitoring_data = Monitoring::with(['input' => function($query) use($monitoring) {
            $query->where('monitoring_id', $monitoring->id)
                ->where('monitoring_category_id', $this->category_id)
                ->where('monitoring_object_id', $this->object_id);
        }, 'input.valueData' => function($query) use($monitoring) {
            $query->where('monitoring_id', $monitoring->id);
        }])->where('id', $monitoring->id)->first();

        $monitorings_header = Monitoring::with('input')->get();
        foreach($monitorings_header as $monitoring_header) {
            $inputs = $monitoring_header->input;
            foreach($inputs as $input_header) {
                foreach($monitoring_data->input as $input) {
                    if($input_header->label == $input->label) {
                        if(!in_array($input->type, $nonInputValue, true)) {
                            $value = InputValue::query()->with('monitoring', 'input', 'input.option')
                            ->where('monitoring_input_id', $input->id)
                            ->where('monitoring_id', $monitoring->id)
                            ->whereHas('input', function($query) use($monitoring_data) {
                                $query->where('monitoring_id', $monitoring_data->id);
                            })->first();
                            if($value != null) {
                                if($input->type == 'text')
                                    $inputs_arr[] = !is_null($value->string_value) ? $value->string_value : '-';
                                if($input->type == 'textarea')
                                    $inputs_arr[] = !is_null($value->text_value) ? strip_tags($value->text_value) : '-';
                                if($input->type == 'number')
                                    $inputs_arr[] = !is_null($value->number_value) ? $value->number_value : '-';
                                if($input->type == 'date')
                                    $inputs_arr[] = !is_null($value->date_value) ? $value->date_value : '-';
                                if($input->type == 'time')
                                    $inputs_arr[] = !is_null($value->time_value) ? $value->time_value : '-';
                                if($input->type == 'checkbox') {
                                    $option_value = '';
                                    foreach($input->option as $option) {
                                        if($option->is_checked == 1)
                                            $option_value .= $option->value.' ,';
                                    }
                                    $option_value .= !is_null($value->string_value) ? $value->string_value : '';
                                    $inputs_arr[] = $option_value;
                                }
                            } else {
                                if($input->type == 'checkbox') {
                                    $option_value = '';
                                    foreach($input->option as $option) {
                                        if($option->is_checked == 1)
                                            $option_value .= $option->value.' ,';
                                    }
                                    $inputs_arr[] = $option_value;
                                }
                                else if($input->type == 'radio') {
                                    $option_value = '';
                                    foreach($input->option as $option) {
                                        if($option->is_checked == 1)
                                            $option_value .= $option->value.' ,';
                                    }
                                    $inputs_arr[] = $option_value;
                                }
                                else if($input->type == 'dropdown') {
                                    $option_value = '';
                                    foreach($input->option as $option) {
                                        if($option->is_checked == 1)
                                            $option_value .= $option->value.' ,';
                                    }
                                    $inputs_arr[] = $option_value;
                                }
                                else
                                    $inputs_arr[] = '-';
                            }
                        }
                        else $inputs_arr[] = '-';
                    }
                }
            }
        }

        $arr = array_merge($data_entity, $inputs_arr);
        return [$arr];
    }

    public function headings(): array
    {
        $data_entity = [
            'Judul',
            'Kategori',
            'Objek',
            'Tanggal Monitoring',
            'Deskripsi',
            'Subjek',
            'Tim',
        ];
        $inputs_arr = [];
        $nonInputValue = ['image', 'description', 'media-youtube', 'file'];
        $categories = Category::with(['input' => function($query) {
            $query
            ->where('monitoring_category_id', $this->category_id)
            ->where('monitoring_object_id', null);
        }])->get();
        foreach($categories as $category) {
            $inputs = $category->input;
            foreach($inputs as $input) {
                if(!in_array($input->type, $nonInputValue, true)) {
                    $inputs_arr[] = $input->label;
                }
            }
        }
        $objects = ObjectData::with(['input' => function($query) {
            $query
            ->where('monitoring_category_id', $this->category_id)
            ->where('monitoring_object_id', $this->object_id)
            ->where('monitoring_id', null);
        }])->get();
        foreach($objects as $object) {
            $inputs = $object->input;
            foreach($inputs as $input) {
                if(!in_array($input->type, $nonInputValue, true)) {
                    $inputs_arr[] = $input->label;
                }
            }
        }
        $monitorings = Monitoring::with('input')->get();
        foreach($monitorings as $monitoring) {
            $inputs = $monitoring->input;
            foreach($inputs as $input) {
                if(!in_array($input->type, $nonInputValue, true)) {
                    $inputs_arr[] = $input->label;
                }
            }
        }
        $arr = array_merge($data_entity, $inputs_arr);
        return $arr;
    }

    public function title(): string
    {
        return $this->year;
    }
}
