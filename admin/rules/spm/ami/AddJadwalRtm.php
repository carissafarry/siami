<?php

namespace app\admin\rules\spm\ami;

use app\includes\Model;
use app\includes\Rule;

class AddJadwalRtm extends Rule
{
    public Model $model;

    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function rules(): array
    {
        return [
            'rtm_mulai' => [self::RULE_REQUIRED],
            'rtm_selesai' => [self::RULE_REQUIRED],
        ];
    }
}