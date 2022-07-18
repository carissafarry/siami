<?php

namespace app\admin\components;

class CountData
{
    public string $header;
    public string $data;
    public string $icon;

    public function __construct($header, $data, $icon)
    {
        $this->header = $header;
        $this->data = $data;
        $this->icon = $icon;
    }

    public function __toString()
    {
        return sprintf('
            <div class="col-xl-4 col-sm-4 mb-xl-0 my-3">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">%s</p>
                                    <h5 class="font-weight-bolder mb-0">%s</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    %s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ',
            $this->header,
            $this->data,
            $this->icon,
        );
    }

}