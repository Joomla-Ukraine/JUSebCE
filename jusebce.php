<?php

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

class plgSystemJUSebCE extends CMSPlugin
{
	protected $app;

	/**
	 * plgSystemJUSebCE constructor.
	 *
	 * @param $subject
	 * @param $config
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->doc = Factory::getDocument();
	}

	/**
	 *
	 * @return bool
	 *
	 * @since 1.0
	 */
	public function onBeforeCompileHead()
	{
		if($this->app->getName() === 'site')
		{
			return true;
		}

		if(!($this->app->input->getCmd('option') === 'com_cck' && $this->app->input->getCmd('view') === 'field' && $this->app->input->getCmd('tmpl') === 'component' && $this->app->input->getCmd('layout') === 'edit'))
		{
			return true;
		}

		$this->doc->addStyleSheet(Uri::root() . 'media/editors/codemirror/lib/codemirror.min.css');
		$this->doc->addStyleSheet('https://fonts.googleapis.com/css?family=Source+Code+Pro');

		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/lib/codemirror.min.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/addon/edit/matchbrackets.min.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/htmlmixed/htmlmixed.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/xml/xml.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/javascript/javascript.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/css/css.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/clike/clike.js', 'text/javascript');
		$this->doc->addScript(Uri::root() . 'media/editors/codemirror/mode/php/php.js', 'text/javascript');

		$css = '<style>
		.CodeMirror
		{
			font-family: \'Source Code Pro\', monospace!important;
			font-size: 14px;;
			line-height: 1.2em;;
			border: 1px solid #ccc;
		}
		.CodeMirror-fullscreen
		{
			z-index: 1040;
		}
		.CodeMirror-foldmarker
		{
			background: rgb(255, 128, 0);
			background: rgba(255, 128, 0, .5);
			box-shadow: inset 0 0 2px rgba(255, 255, 255, .5);
			font-family: serif;
			font-size: 90%;
			border-radius: 1em;
			padding: 0 1em;
			vertical-align: middle;
			color: white;
			text-shadow: none;
		}
		.CodeMirror-foldgutter, .CodeMirror-markergutter { width: 1.2em; text-align: center; }
		.CodeMirror-markergutter { cursor: pointer; }
		.CodeMirror-markergutter-mark { cursor: pointer; text-align: center; }
		.CodeMirror-markergutter-mark:after { content: "CF"; }
		.CodeMirror-activeline-background { background: rgba(164, 194, 235, .5); }
		.CodeMirror-matchingtag { background: rgba(250, 84, 47, .5); }
		.cm-matchhighlight {background-color: rgba(250, 84, 47, .5); }
		.CodeMirror-selection-highlight-scrollbar {background-color: rgba(250, 84, 47, .5); }
		</style>';

		$this->doc->addCustomTag($css);

		$this->doc->addScriptDeclaration(<<<JS
		(function () {
		    document.addEventListener('DOMContentLoaded', function () {
	
				var options = {
				    lineNumbers: true,
			        matchBrackets: true,
			        mode: "text/x-php",
			        indentUnit: 4,
			        indentWithTabs: true
			    },
			    mixedMode = {
				    lineNumbers: true,
			        matchBrackets: true,
			        indentUnit: 4,
			        indentWithTabs: true,		        
	                name: "htmlmixed",
	                scriptTypes: [
	                    {
	                        matches: /\/x-handlebars-template|\/x-mustache/i,
	                        mode: null
	                    }, {
	                        matches: /(text|application)\/(x-)?vb(a|script)/i,
	                       mode: "vbscript"
	                    }
	                ]
	            };
			    
			    addCM('json_options2_code', options);
			    addCM('json_options2_preparecontent', options);
			    addCM('json_options2_prepareform', options);
			    addCM('json_options2_preparestore', options);
			    addCM('json_options2_html', mixedMode);
			    
			    function addCM(elID, options) {
			        var el = document.getElementById(elID);
			
				    if (typeof el !== "undefined" && el !== null) {
						return CodeMirror.fromTextArea(el, options);
					}
			    }
		    });
	   	})();
JS
		);

		return true;
	}
}