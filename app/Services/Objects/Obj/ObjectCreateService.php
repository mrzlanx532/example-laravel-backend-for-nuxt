<?php

namespace App\Services\Objects\Obj;

use App\Models\Objects\Obj;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Mrzlanx532\LaravelBasicComponents\Service\Service;

class ObjectCreateService extends Service
{
    public function getRules(): array
    {
        return [
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

    /**
     * @throws ValidationException
     */
    public function handle(): Obj
    {
        if (!$this->params) {
            throw ValidationException::withMessages([]);
        }

        $throw = false;

        foreach ($this->params as $paramName => $paramValue) {
            if ($paramValue !== null) {
                continue;
            }

            $throw = true;
        }

        if ($throw) {
            throw ValidationException::withMessages([]);
        }

        $pencil = new Obj;

        $pencil->example_checkbox = $this->params['example_checkbox'] ?? null;
        $pencil->example_date = isset($this->params['example_date']) && $this->params['example_date'] !== null ? Carbon::createFromFormat('d.m.Y', $this->params['example_date']) : null;
        $pencil->example_datetime = isset($this->params['example_datetime']) && $this->params['example_datetime'] !== null ? Carbon::createFromFormat('d.m.Y H:i', $this->params['example_datetime']) : null;
        $pencil->example_editor = $this->params['example_editor'] ?? null;
        $pencil->example_input = $this->params['example_input'] ?? null;
        $pencil->example_input_file = $this->params['example_input_file'] ?? null;
        $pencil->example_select = $this->params['example_select'] ?? null;
        $pencil->example_select_wrap = isset($this->params['example_select_wrap']) ? json_encode($this->params['example_select_wrap']) : null;
        $pencil->example_switcher = $this->params['example_switcher'] ?? null;
        $pencil->example_textarea = $this->params['example_textarea'] ?? null;

        $pencil->save();

        return $pencil;
    }
}