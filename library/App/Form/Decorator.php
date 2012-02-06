<?php

namespace App\Form;

class Decorator
{
    /**
     * Constants Definition for Decorator
     */
    const TABLE = 'table';
    const DIV = 'div';
    const BOOTSTRAP = 'bootstrap';

    /**
     * Element Decorator
     *
     * @var array
     */
    protected $_elementDecorator = array(
        'table' => array(
            'ViewHelper',
            array(
                'Description',
                array(
                    'tag' => '',
                )
            ),
            'Errors',
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                'Label',
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr'
                )
            )
        ),
        'div' => array(
            array(
                'ViewHelper'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'hint'
                )
            ),
            array(
                'Errors'
            ),
            array(
                'Label'
            ),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div'
                )
            )
        ),
        'bootstrap' => array(
            array(
                'ViewHelper'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'help-inline',
                )
            ),
            array(
                'BootstrapErrors'
            ),
            array(
                'BootstrapTag',
                array(
                    'class' => 'controls'
                )
            ),
            array(
                'Label',
                array(
                    'class' => 'control-label'
                )
            ),
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'control-group'
                )
            )
        )
    );
    
    /**
     * Captcha Decorator
     *
     * @var array
     */
    protected $_captchaDecorator = array(
        'table' => array(
            'Errors', 
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                'Label',
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr'
                )
            )
        ),
        'div' => array(
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'hint'
                )
            ),
            array(
                'Errors'
            ),
            array(
                'Label'
            ),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div'
                )
            )
        ),
        'bootstrap' => array(
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'help-inline',
                )
            ),
            array(
                'BootstrapErrors'
            ),
            array(
                'BootstrapTag',
                array(
                    'class' => 'controls'
                )
            ),
            array(
                'Label',
                array(
                    'class' => 'control-label'
                )
            ),
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'control-group'
                )
            )
        )
    );
    
    /**
     * Multi Decorator
     *
     * @var array
     */
    protected $_multiDecorator = array(
        'table' => array(
            'ViewHelper',
            array(
                'Description',
                array(
                    'tag' => '',
                )
            ),
            'Errors',
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                'Label',
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr'
                )
            )
        ),
        'div' => array(
            array(
                'ViewHelper'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'hint'
                )
            ),
            array(
                'Errors'
            ),
            array(
                'Label'
            ),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div'
                )
            )
        ),
        'bootstrap' => array(
            array(
                'ViewHelper'
            ),
            array(
                'BootstrapErrors'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'help-blocks',
                )
            ),
            array(
                array(
                    'listelement' => 'HtmlTag'
                ),
                array(
                    'tag'   => 'li',
                )
            ),
            array(
                array(
                    'list' => 'HtmlTag'
                ),
                array(
                    'tag'   => 'ul',
                    'class' => 'inputs-list'
                )
            ),
            array(
                'BootstrapTag',
                array(
                    'class' => 'controls'
                )
            ),
            array(
                'Label',
                array(
                    'class' => 'control-label'
                )
            ),
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'control-group'
                )
            )
        )
    );

    /**
     * Submit Element Decorator
     *
     * @var array
     */
    protected $_submitDecorator = array(
        'table' => array(
            'ViewHelper', 
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr',
                    'class' => 'buttons'
                )
            )
        ),
        'div' => array(
            'ViewHelper'
        ),
        'bootstrap' => array(
            'ViewHelper',
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'form-actions',
                    'openOnly' => FALSE
                )
            )
        )
    );

    /**
     * Reset Element Decorator
     *
     * @var array
     */
    protected $_resetDecorator = array(
        'table' => array(
            'ViewHelper', 
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr'
                )
            )
        ),
        'div' => array(
            'ViewHelper'
        ),
        'bootstrap' => array(
            'ViewHelper',
            array(
                'HtmlTag',
                array(
                    'closeOnly' => FALSE
                )
            )
        )
    );

    /**
     * Hiden Element Decorator
     *
     * @var array
     */
    protected $_hiddenDecorator = array(
        'table' => array(
            'ViewHelper'
        ),
        'div' => array(
            'ViewHelper',
        ),
        'bootstrap' => array(
            'ViewHelper',
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'control-group hide'
                )
            )
        )
    );

    /**
     * Form Element Decorator
     *
     * @var array
     */
    protected $_formDecorator = array(
        'table' => array(
            'FormElements',
            'Fieldset',
            'Form'
        ),
        'div' => array(
            'FormElements',
            'Fieldset',
            'Form'
        ),
        'bootstrap' => array(
            'FormElements',
            'Fieldset',
            'Form'
        )
    );

    /**
     * DisplayGroup Decorator
     *
     * @var array
     */
    protected $_displayGroupDecorator = array(
        'table' => array(
            'FormElements',
            array(
                'HtmlTag',
                array(
                    'tag' => 'table',
                    'summary' => ''
                )
            ),
            'Fieldset'
        ),
        'div' => array(
            'FormElements',
            'Fieldset'
        ),
        'bootstrap' => array(
            'FormElements',
            'Fieldset'
        )
    );
    
    /**
     * ZendX_Jquery Decorator
     *
     * @var array
     */
    protected $_jqueryElementDecorator = array(
        'table' => array(
            'UiWidgetElement',
            array(
                'Description',
                array(
                    'tag' => '',
                )
            ),
            'Errors',
            array(
                array(
                    'data' => 'HtmlTag'
                ),
                array(
                    'tag' => 'td'
                )
            ),
            array(
                'Label',
                array(
                    'tag' => 'td'
                )
            ),
            array(
                array(
                    'row' => 'HtmlTag'
                ),
                array(
                    'tag' => 'tr'
                )
            )
        ),
        'div' => array(
            array(
                'UiWidgetElement'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'hint'
                )
            ),
            array(
                'Errors'
            ),
            array(
                'Label'
            ),
            array(
                'HtmlTag',
                array(
                    'tag' => 'div'
                )
            )
        ),
        'bootstrap' => array(
            array(
                'UiWidgetElement'
            ),
            array(
                'Description',
                array(
                    'tag'   => 'span',
                    'class' => 'help-inline'
                )
            ),
            array(
                'BootstrapErrors'
            ),
            array(
                'BootstrapTag',
                array(
                    'class' => 'controls'
                )
            ),
            array(
                'Label',
                array(
                    'class' => 'control-label'
                )
            ),
            array(
                'HtmlTag',
                array(
                    'tag'   => 'div',
                    'class' => 'control-group'
                )
            )
        )
    );    

    /**
     * Set the form decorators by the given string format or by the default div style
     *
     * @param \Zend_Form $form Zend_Form pointer-reference
     * @param string $format    Project_Plugin_FormDecoratorDefinition constants
     * @param string $submitName
     * @param string $cancelName
     * @return NULL
     */
    public function setFormDecorator(\Zend_Form $form, $format = self::BOOTSTRAP,
        $submitName = 'submit', $cancelName = 'cancel')
    {        
        /**
         * - disable default decorators
         * - set form & displaygroup decorators
         */
        $form->setDisableLoadDefaultDecorators(TRUE);
        $form->setDisplayGroupDecorators($this->_displayGroupDecorator[$format]);
        $form->setDecorators($this->_formDecorator[$format]);

        // set needed prefix path for bootstrap decorators
        if ($format == self::BOOTSTRAP) {
            $form->addElementPrefixPath(
                'App\Form\Decorator\\',
                "App/Form/Decorator",
                \Zend_Form::DECORATOR
            );
        }

        // set form element decorators
        $form->setElementDecorators($this->_elementDecorator[$format]);

        // set submit button decorators
        $this->_setSubmitButtonDecorator($form, $format, $submitName, $cancelName);

        // set cancel button decorators
        $this->_setCancelButtonDecorator($form, $format, $submitName, $cancelName);

        // set hidden, captcha, multi input decorators
        $this->_setOtherDecorators($form, $format);
    }
    
    /**
     * Set submit button decorators
     * 
     * @param \Zend_Form $form
     * @param string $format
     * @param string $submitName
     * @param string $cancelName 
     */
    private function _setSubmitButtonDecorator(\Zend_Form $form, $format, $submitName, $cancelName)
    {
        if ($form->getElement($submitName)) {
            $form->getElement($submitName)->setDecorators($this->_submitDecorator[$format]);
            if ($format == self::BOOTSTRAP) {
                $attribs = $form->getElement($submitName)->getAttrib('class');
                if (empty($attribs)) {
                    $attribs = array('btn', 'btn-primary');
                } else {
                    if (is_string($attribs)) {
                        $attribs = array($attribs);
                    }
                    $attribs = array_unique(array_merge(array('btn'), $attribs));
                }
                $form->getElement($submitName)
                    ->setAttrib('class', $attribs);
                if ($form->getElement($cancelName)) {
                    $form->getElement($submitName)->getDecorator('HtmlTag')
                        ->setOption('openOnly', TRUE);
                }
            }
            if ($format == self::TABLE) {
                if ($form->getElement($cancelName)) {
                    $form->getElement($submitName)->getDecorator('data')
                        ->setOption('openOnly', TRUE);
                    $form->getElement($submitName)->getDecorator('row')
                        ->setOption('openOnly', TRUE);
                }
            }
        }
    }
    
    /**
     * Set cancel button decorators
     * 
     * @param \Zend_Form $form
     * @param string $format
     * @param string $submitName
     * @param string $cancelName 
     */
    private function _setCancelButtonDecorator(\Zend_Form $form, $format, $submitName, $cancelName)
    {
        if ($form->getElement($cancelName)) {
            $form->getElement($cancelName)->setDecorators($this->_resetDecorator[$format]);
            if ($format == self::BOOTSTRAP) {
                $attribs = $form->getElement($cancelName)->getAttrib('class');
                if (empty($attribs)) {
                    $attribs = array('btn');
                } else {
                    if (is_string($attribs)) {
                        $attribs = array($attribs);
                    }
                    $attribs = array_unique(array_merge(array('btn'), $attribs));
                }
                $form->getElement($cancelName)
                    ->setAttrib('class', $attribs);
                if ($form->getElement($submitName)) {
                    $form->getElement($cancelName)->getDecorator('HtmlTag')
                        ->setOption('closeOnly', TRUE);
                }
            }
            if ($format == self::TABLE) {
                if ($form->getElement($submitName)) {
                    $form->getElement($cancelName)->getDecorator('data')
                        ->setOption('closeOnly', TRUE);
                    $form->getElement($cancelName)->getDecorator('row')
                        ->setOption('closeOnly', TRUE);
                }
            }
        }
    }
    
    /**
     * Sets hidden captcha, multi input decorators
     * 
     * @param \Zend_Form $form
     * @param string $format 
     */
    private function _setOtherDecorators(\Zend_Form $form, $format)
    {
        foreach ($form->getElements() as $exc) {
            if ($exc->getType() == 'Zend_Form_Element_Hidden') {
                $exc->setDecorators($this->_hiddenDecorator[$format]);
            }
            if ($exc->getType() == 'Zend_Form_Element_Captcha') {
                $exc->setDecorators($this->_captchaDecorator[$format]);
            }
            if ($exc->getType() == 'Zend_Form_Element_MultiCheckbox') {
                $exc->setDecorators($this->_multiDecorator[$format]);
                $exc->setSeparator('</li><li>');
            }
            if ($exc->getType() == 'Zend_Form_Element_Radio') {
                $exc->setDecorators($this->_multiDecorator[$format]);
                $exc->setSeparator('</li><li>');
            }
            if (is_subclass_of($exc, "ZendX_JQuery_Form_Element_UiWidget")) {
                $exc->setDecorators($this->_jqueryElementDecorator[$format]);
            }
        }
    }
}
