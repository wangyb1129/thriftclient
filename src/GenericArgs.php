<?php

namespace Thrift\Client;
use Thrift\Type\TType;
use Thrift\Exception\TProtocolException;

class GenericArgs
{
    static $TSPEC = array(
        1 => array(
            'var' => 'jsonParams',
            'type' => TType::STRING,
        ),
    );

    public $jsonParams = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['jsonParams'])) {
                $this->jsonParams = $vals['jsonParams'];
            }
        }
    }

    public function read($input)
    {
        $xfer = 0;
        $fname = null;
        $ftype = 0;
        $fid = 0;
        $xfer += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == TType::STOP) {
                break;
            }
            switch ($fid) {
                case 1:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->jsonParams);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }

    public function write($output)
    {
        $xfer = 0;
        $xfer += $output->writeStructBegin('GenericArgs');
        if ($this->jsonParams !== null) {
            $xfer += $output->writeFieldBegin('jsonParams', TType::STRING, 1);
            $xfer += $output->writeString($this->jsonParams);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
