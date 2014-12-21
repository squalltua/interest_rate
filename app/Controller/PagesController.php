<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
	public $uses = array();

    /**
     * Displays a view
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *	or MissingViewException in debug mode.
     */
	public function home() {
        
        // check for send by post
		if ($this->request->is('post')) {
            
            if ($this->check_value($this->data['Page']['interest'])
                && $this->check_value($this->data['Page']['term'])
                && $this->check_value($this->data['Page']['loan_amount'])) {
                // load data from form
                $loan_amount    = $this->data['Page']['loan_amount'];
                $term           = $this->data['Page']['term'];
                $interest       = $this->data['Page']['interest'];

                // calulate PMT
                $pmt            = $this->pmt($interest, $term, $loan_amount);

                // set data to view.
                $this->set(compact('loan_amount', 'term', 'interest', 'pmt'));
                
            } else {
                // display message error.
                return $this->Session->setFlash('Data error. Please try again.', 'error_flash');        
            }
        }
	}
    
    /**
     * pmt methode
     * PMT in Excel. The monthly mortgage amount.
     * @credit http://drastikbydesign.com/blog-entry/excel-pmt-php-cleaner
     *
     * @param float     $apr    Interest rate.
     * @param integer   $term   Loan length in years.
     * @param float     $loan   The loan amount.
     *
     * @return float            
    */
    private function pmt($apr, $term, $loan) {
        $term = $term * 12;
        $apr = $apr / 1200;
        $amount = $apr * -$loan * pow((1 + $apr), $term) / (1 - pow((1 + $apr), $term));
        return $amount;
    }
    
    /**
     * check_value method
     * for IE checker can't support fully HTML5 syntex
     *
     * @param   integer or float    $val    value for check
     * @return  boolean
     */
    private function check_value($val = null) {
        if (!empty($val)) {
            if (is_float($val) || is_numeric($val)) {
                return true;   
            }
        }
        
        return false;
    }
}
