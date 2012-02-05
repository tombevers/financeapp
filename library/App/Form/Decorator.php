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
     * @staticvar array
     */
    protected static $_elementDecorator = array(
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
     * @staticvar array
     */
    protected static $_captchaDecorator = array(
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
     * @staticvar array
     */
    protected static $_multiDecorator = array(
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
     * @staticvar array
     */
    protected static $_submitDecorator = array(
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
     * @staticvar array
     */
    protected static $_resetDecorator = array(
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
     * @staticvar array
     */
    protected static $_hiddenDecorator = array(
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
     * @staticvar array
     */
    protected static $_formDecorator = array(
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
     * @staticvar array
     */
    protected static $_displayGroupDecorator = array(
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
     * @staticvar array
     */
    protected static $_jqueryElementDecorator = array(
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
     * @param object $objForm        Zend_Form pointer-reference
     * @param string $constFormat    Project_Plugin_FormDecoratorDefinition constants
     * @return NULL
     */
    public static function setFormDecorator(\Zend_Form $form, $format = self::BOOTSTRAP,
        $submitName = 'submit', $cancelName = 'cancel')
    {
        /**
         * - disable default decorators
         * - set form & displaygroup decorators
         */
        $form->setDisableLoadDefaultDecorators(TRUE);
        $form->setDisplayGroupDecorators(self::$_displayGroupDecorator[$format]);
        $form->setDecorators(self::$_formDecorator[$format]);

        // set needed prefix path for bootstrap decorators
        if ($format == self::BOOTSTRAP) {
            $form->addElementPrefixPath(
                'App\Form\Decorator\\',
                "App/Form/Decorator",
                \Zend_Form::DECORATOR
            );
        }

        // set form element decorators
        $form->setElementDecorators(self::$_elementDecorator[$format]);

        // set submit button decorators
        if ($form->getElement($submitName)) {
            $form->getElement($submitName)->setDecorators(self::$_submitDecorator[$format]);
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

        // set cancel button decorators
        if ($form->getElement($cancelName)) {
            $form->getElement($cancelName)->setDecorators(self::$_resetDecorator[$format]);
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

        // set hidden, cpatcha, multi input decorators
        foreach ($form->getElements() as $exc) {
            if ($exc->getType() == 'Zend_Form_Element_Hidden') {
                $exc->setDecorators(self::$_hiddenDecorator[$format]);
            }
            if ($exc->getType() == 'Zend_Form_Element_Captcha') {
                $exc->setDecorators(self::$_captchaDecorator[$format]);
            }
            if ($exc->getType() == 'Zend_Form_Element_MultiCheckbox') {
                $exc->setDecorators(self::$_multiDecorator[$format]);
                $exc->setSeparator('</li><li>');
            }
            if ($exc->getType() == 'Zend_Form_Element_Radio') {
                $exc->setDecorators(self::$_multiDecorator[$format]);
                $exc->setSeparator('</li><li>');
            }
            if (is_subclass_of($exc, "ZendX_JQuery_Form_Element_UiWidget")) {
                $exc->setDecorators(self::$_jqueryElementDecorator[$format]);
            }
        }
    }
}
