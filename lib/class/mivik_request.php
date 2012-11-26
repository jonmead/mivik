<?php 
class mivik_request extends mivik_magicMembers{
	/**
	 * 
	 * @var mivik_url
	 */
	public $url;
	public $activeController;
	public $activeAction;
	public $activeTemplate;
	public $appBase;
	/**
	 * 
	 * @var mivik_config
	 */
	public $config;
	/**
	 * 
	 * @var mivik_session
	 */
	public $session;
	public $actionOutput;
	/**
	 * 
	 * @var mivik_args
	 */
	public $args;
}