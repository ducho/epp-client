<?php

namespace Struzik\EPPClient\Response\Domain;

use Struzik\EPPClient\Response\CommonResponse;
use Struzik\EPPClient\Node\Common\Contact;

/**
 * Object representation of the response of domain information command.
 */
class Info extends CommonResponse
{
    /**
     * Fully qualified name of the domain object.
     *
     * @return string
     */
    public function getDomain()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:name');

        return $node->nodeValue;
    }

    /**
     * Unique identifier in the registry.
     *
     * @return string
     */
    public function getROIdentifier()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:roid');

        return $node->nodeValue;
    }

    /**
     * List of object statuses.
     *
     * @return \Generator
     */
    public function getStatuses()
    {
        $nodes = $this->get('//epp:epp/epp:response/epp:resData/domain:infData/domain:status');

        foreach ($nodes as $node) {
            yield $node->getAttribute('s');
        }
    }

    /**
     * Check status existence.
     *
     * @param string $status string representation of the status
     *
     * @return bool
     */
    public function statusExist($status)
    {
        $generator = $this->getStatuses();
        $list = iterator_to_array($generator);

        return in_array($status, $list);
    }

    /**
     * Nichandle of the domain registrant.
     *
     * @return string
     */
    public function getRegistrant()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:registrant');
        if ($node === null) {
            return null;
        }

        return $node->nodeValue;
    }

    /**
     * Other nichandles with the types associated with the domain object.
     *
     * @return \Generator
     */
    public function getContacts()
    {
        $nodes = $this->get('//epp:epp/epp:response/epp:resData/domain:infData/domain:contact');

        foreach ($nodes as $node) {
            yield $node->getAttribute('type') => $node->nodeValue;
        }
    }

    /**
     * List of domain nameservers.
     *
     * @return \Generator
     */
    public function getNameservers()
    {
        $nodes = $this->get('//epp:epp/epp:response/epp:resData/domain:infData/domain:ns/domain:hostObj');

        foreach ($nodes as $node) {
            yield $node->nodeValue;
        }
    }

    /**
     * List of fully qualified names of the subordinate host objects that exist under this superordinate domain object.
     *
     * @return \Generator
     */
    public function getHosts()
    {
        $nodes = $this->get('//epp:epp/epp:response/epp:resData/domain:infData/domain:host');

        foreach ($nodes as $node) {
            yield $node->nodeValue;
        }
    }

    /**
     * The identifier of the sponsoring client.
     *
     * @return string
     */
    public function getClientId()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:clID');

        return $node->nodeValue;
    }

    /**
     * The identifier of the client that created the domain object.
     *
     * @return string|null
     */
    public function getCreatorId()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:crID');
        if ($node === null) {
            return null;
        }

        return $node->nodeValue;
    }

    /**
     * The date and time of domain object creation.
     *
     * @param string|null $format format of the date string
     *
     * @return \DateTime|string|null
     */
    public function getCreateDate($format = null)
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:crDate');
        if ($node === null) {
            return null;
        }

        if ($format === null) {
            return $node->nodeValue;
        }

        return date_create_from_format($format, $node->nodeValue);
    }

    /**
     * The date and time identifying the end of the domain object's registration period.
     *
     * @param string|null $format format of the date string
     *
     * @return \DateTime|string|null
     */
    public function getExpiryDate($format = null)
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:exDate');
        if ($node === null) {
            return null;
        }

        if ($format === null) {
            return $node->nodeValue;
        }

        return date_create_from_format($format, $node->nodeValue);
    }

    /**
     * The identifier of the client that last updated the domain object.
     *
     * @return string|null
     */
    public function getUpdaterId()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:upID');
        if ($node === null) {
            return null;
        }

        return $node->nodeValue;
    }

    /**
     * The date and time of the most recent domain object modification.
     *
     * @param string|null $format format of the date string
     *
     * @return \DateTime|string|null
     */
    public function getUpdateDate($format = null)
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:upDate');
        if ($node === null) {
            return null;
        }

        if ($format === null) {
            return $node->nodeValue;
        }

        return date_create_from_format($format, $node->nodeValue);
    }

    /**
     * The date and time of the most recent successful domain object transfer.
     *
     * @param string|null $format format of the date string
     *
     * @return \DateTime|string|null
     */
    public function getTransferDate($format = null)
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:trDate');
        if ($node === null) {
            return null;
        }

        if ($format === null) {
            return $node->nodeValue;
        }

        return date_create_from_format($format, $node->nodeValue);
    }

    /**
     * Authorization information associated with the domain object.
     *
     * @return string|null
     */
    public function getAuthCode()
    {
        $node = $this->getFirst('//epp:epp/epp:response/epp:resData/domain:infData/domain:authInfo/domain:pw');
        if ($node === null) {
            return null;
        }

        return $node->nodeValue;
    }
}
