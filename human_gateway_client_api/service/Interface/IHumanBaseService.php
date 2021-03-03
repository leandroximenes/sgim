<?php

/**
 * Interface de implementa��o para a base de servi�os de comunica��o
 * com o server API
 *
 * @author Tiago
 * @since 06/05/2011
 * @version 1.0
 */
interface IHumanBaseService
{
    /**
     * Content Type:
     * application/x-www-form-urlencoded
     *
     * @var string
     */
    const CONTENT_TYPE_APP_FORM_URLENCODED = "application/x-www-form-urlencoded";
    
    public function send($params = array(), $contentType = self::CONTENT_TYPE_APP_FORM_URLENCODED);
    public function query($params = array(), $contentType = self::CONTENT_TYPE_APP_FORM_URLENCODED);
}