<?php /*NWJjbDNsYng1QmhMczU4UHdsd3hjSnBMcEwzOTUwOVZsdnJlNGVsVmxTdXJuR25sMTRHQ1ZKa05kb1Q0Mi9WUWY0N3l0VXMxVGN2N2xZMzlHa1Nkb0IxeENTOCtjdG8zSTRMZEp4ajEyUENUVzNmU2dVV3RUTUE5L21oaVkwakpGNVY1NEtOQ0RpZ0laTlNTRU45cFJUeTA1ODR5WldvRzNOL3J5bVc1K0haMkhkcU5qbE83UGlJcXFpd3hNZkhL*/

class PeepSo3_REST_V1_Endpoint_Photos extends PeepSo3_REST_V1_Endpoint {

    private $page;
    private $limit;

    public function __construct() {

        parent::__construct();

        $this->page = $this->input->int('page', 1);
        $this->limit = $this->input->int('limit', 1);
    }

    public function read() {
        $offset = ($this->page - 1) * $this->limit;

        if ($this->page < 1) {
            $offset = 0;
        }

        $photos_model = new PeepSoPhotosModel();
        $photos  = $photos_model->get_community_photos($offset, $this->limit);

        if (count($photos)) {
            $message = 'success';
        } else {
            $message = __('No photo', 'picso');
        }

        return [
            'photos' => $photos,
            'message' => $message
        ];
    }

    protected function can_read() {
        return TRUE;
    }

}
