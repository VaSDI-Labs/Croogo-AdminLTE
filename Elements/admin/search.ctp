<?php /** @var ViewTheme $this */

if (empty($modelClass)) $modelClass = Inflector::singularize($this->name);
if (!isset($className)) $className = strtolower($this->name);
if (!empty($searchFields)):
?>
    <div class="box box-primary <?php echo $className; ?> filter">
        <div class="box-body">
            <?php
            echo $this->Form->create($modelClass, [
                'class' => 'form-inline',
                'novalidate' => true,
                'url' => [
                    'plugin' => $this->request->params['plugin'],
                    'controller' => $this->request->params['controller'],
                    'action' => $this->request->params['action'],
                ]
            ]);

            if (isset($this->request->query['chooser'])):
                echo $this->Form->input('chooser', [
                    'type' => 'hidden',
                    'value' => isset($this->request->query['chooser']),
                ]);
            endif;

            foreach ($searchFields as $field => $fieldOptions) {
                $options = ['empty' => '', 'required' => false, 'tooltip' => false, 'label' => false];
                if (is_numeric($field) && is_string($fieldOptions)) {
                    $field = $fieldOptions;
                    $fieldOptions = array();
                }
                if (!empty($fieldOptions)) {
                    $options = Hash::merge($fieldOptions, $options);
                }
                $placeholder = $field;
                if (substr($placeholder, -3) === '_id') {
                    $placeholder = substr($placeholder, 0, -3);
                }
                $placeholder = __(Inflector::humanize(Inflector::underscore($placeholder)));
                $options['placeholder'] = __d('croogo', $placeholder);
                $this->Form->unlockField($field);
                echo $this->Form->input($field, $options);
            }

            echo $this->Form->button(__d('croogo', 'Filter'), [
                'type' => 'submit',
                'id' => 'searchFilter'
            ]);
            echo $this->Form->end();

            ?>
        </div>

    </div>
<?php endif; ?>
