# Braintree module

Braintree payments system integration library. Futures:

* single card transaction
* single card transaction with registration
* single charge already registered user
* standard form elements for card payment
* standard form for customer registration
* abstract customer entity for quick database integration 
* country collection with filtering mechanism for taxation system (EU, non-EU)

## Installation

To integrate module into your application perform next steps:

1. Add Common Compnent submodule: `git add submodule git@bitbucket.org:thestory/common-components-module.git module/Common`
2. Add Braintree Payments submodule: `git add submodule git@bitbucket.org:thestory/braintree-payments-module.git module/BraintreePayments`

## Standard forms

Module provides 2 common fieldsets with validation and filtering logic for further use in application forms:

* **\BraintreePayments\Form\CreditCardFieldset** - use for credit card data collecting
* **\BraintreePayments\Form\CustomerFieldset** - use for customer data collecting

Example use:

    // Application form class

    namespace Application\Form;
    
    use Zend\Form\Form;
    
    class SingleTransactionForm extends Form
    {
        public function init()
        {
            $this->setAttribute('method', 'post');
    
            $this->add([
                'type' => 'BraintreePayments\Form\CreditCardFieldset',
            ]);
    
            $this->add([
                'name' => 'submit',
                'type' => 'button',
                'options' => [
                    'label' => 'Charge',
                ],
                'attributes' => [
                    'type' => 'submit',
                ],
            ]);
        }
    }
    
    // In controller
    
    namespace Application\Controller;
    
    use Common\Controller\AbstractController;
    
    class YourController extends AbstractController
    {
        public function singleTransactionAction()
        {
            $form = $this->getFormElementManager()->get('form.single_transaction');
    
            $viewModel = new ViewModel([
                'form' => $form,
            ]);
    
            if ($this->getRequest()->isPost()) {
                $form->setData($this->params()->fromPost());
    
                // all validation logic is included in fieldsets
                if ($form->isValid()) {
                    $readyForUseData = $form->getData(); // get filtered and properly formatted user input
                    // process data
                    // ...
                }
            }
    
            return $viewModel;
        }
    }

## Single transaction

Simple transaction example with standard form elements

    
    