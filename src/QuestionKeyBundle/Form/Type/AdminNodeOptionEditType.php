<?php

namespace QuestionKeyBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use QuestionKeyBundle\Entity\NodeOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackValidator;
use Symfony\Component\Form\FormBuilderInterface;


/**
 *  @license 3-clause BSD
 *  @link https://github.com/QuestionKey/QuestionKey-Core
 */
class AdminNodeOptionEditType extends AbstractType {


    /** @var  NodeOption */
    protected $nodeOption;


    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder->add('title', 'text', array(
            'required' => true,
            'label'=>'Title'
        ));


        $builder->add('body_text', 'textarea', array(
            'required' => false,
            'label'=>'Body (Text)'
        ));

        $builder->add('body_html', 'textarea', array(
            'required' => false,
            'label'=>'Body (HTML)'
        ));


        $builder->add('sort', 'text', array(
            'required' => true,
            'label'=>'Sort'
        ));

        $this->nodeOption = $builder->getData();

        $builder->add('destination_node', 'entity', array(
            'required' => true,
            'label'=>'Destination Node',
            'class' => 'QuestionKeyBundle:Node',
            'expanded'=>true,
            'multiple'=>false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.treeVersion = :tree_version')
                    ->setParameter('tree_version', $this->nodeOption->getNode()->getTreeVersion())
                    ->orderBy('u.title', 'ASC');
            },
        ));

    }

    public function getName() {
        return 'node';
    }

    public function getDefaultOptions(array $options) {
        return array(
            'data_class' => 'QuestionKeyBundle\Entity\NodeOption',
        );
    }
}
