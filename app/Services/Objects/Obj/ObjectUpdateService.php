<?php

namespace App\Services\Objects\Obj;

use App\Models\Objects\Obj;
use Illuminate\Support\Carbon;
use Mrzlanx532\LaravelBasicComponents\Service\Service;

class ObjectUpdateService extends Service
{
    public function getRules(): array
    {
        return [
            'id' => 'required|int',
            'example_checkbox' => 'nullable|boolean',
            'example_date' => 'nullable|date|date_format:d.m.Y',
            'example_datetime' => 'nullable|date|date_format:d.m.Y H:i',
            'example_editor' => 'nullable|string',
            'example_input' => 'nullable|string',
            'example_input_file' => 'nullable|file',
            'example_select' => 'nullable|int',
            'example_select_wrap' => 'nullable|array',
            'example_select_wrap.*' => 'required|int',
            'example_switcher' => 'nullable|bool',
            'example_textarea' => 'nullable|string',
        ];
    }

    public function handle(): Obj
    {
        $pencil = Obj::find($this->params['id']);

        $pencil->example_checkbox = array_key_exists('example_checkbox', $this->params) ? $this->params['example_checkbox'] : $pencil->example_checkbox;
        $pencil->example_date = array_key_exists('example_date', $this->params) && $this->params['example_date'] !== null ? Carbon::createFromFormat('d.m.Y', $this->params['example_date']) : null;
        $pencil->example_datetime = array_key_exists('example_datetime', $this->params) && $this->params['example_datetime'] !== null ? Carbon::createFromFormat('d.m.Y H:i', $this->params['example_datetime']) : null;
        $pencil->example_editor = array_key_exists('example_editor', $this->params) ? $this->params['example_editor'] : $pencil->example_editor;
        $pencil->example_input = array_key_exists('example_input', $this->params) ? $this->params['example_input'] : $pencil->example_input;
        $pencil->example_input_file = array_key_exists('example_input_file', $this->params) ? $this->params['example_input_file'] : $pencil->example_input_file;
        $pencil->example_select = array_key_exists('example_select', $this->params) ? $this->params['example_select'] : $pencil->example_select;
        $pencil->example_select_wrap = isset($this->params['example_select_wrap']) && $this->params['example_select_wrap'] ? json_encode($this->params['example_select_wrap']) : null;
        $pencil->example_switcher = array_key_exists('example_switcher', $this->params) ? $this->params['example_switcher'] : $pencil->example_switcher;
        $pencil->example_textarea = array_key_exists('example_textarea', $this->params) ? $this->params['example_textarea'] : $pencil->example_textarea;
        $pencil->save();

        return $pencil;
    }
}