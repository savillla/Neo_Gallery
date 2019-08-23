<?php
/**
 * @category   Neo
 * @package    Gallery
 * @author     bacnguyennnnnn@gmail.com
 */
namespace Neo\Gallery\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
	/**
     * @var \Magento\Eav\Model\Entity\Type
     */
	protected $_entityTypeModel;

    /**
     * @var \Magento\Eav\Model\Entity\Attribute
     */
    protected $_catalogAttribute;
    
    /**
     * @var \Magento\Eav\Setup\EavSetupe
     */
    protected $_eavSetup;

    /**
     * @param \Magento\Eav\Setup\EavSetup         $eavSetup         
     * @param \Magento\Eav\Model\Entity\Type      $entityType       
     * @param \Magento\Eav\Model\Entity\Attribute $catalogAttribute 
     */
    public function __construct(
    	\Magento\Eav\Setup\EavSetup $eavSetup,
    	\Magento\Eav\Model\Entity\Type $entityType,
    	\Magento\Eav\Model\Entity\Attribute $catalogAttribute
    	) {
    	$this->_eavSetup = $eavSetup;
    	$this->_entityTypeModel = $entityType;
    	$this->_catalogAttribute = $catalogAttribute;
    }

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
    	$entityTypeModel = $this->_entityTypeModel;
    	$catalogAttributeModel = $this->_catalogAttribute;
    	$installer =  $this->_eavSetup;

    	$setup->startSetup();

		/**
		 * Drop table if exists
		 */
		//$setup->getConnection()->dropTable($setup->getTable('neo_imagegallery_gallery'));
		$setup->getConnection()->dropTable($setup->getTable('neo_gallery_image'));
		//$setup->getConnection()->dropTable($setup->getTable('neo_imagegallery_store'));

 		/**
 		 * Create table 'neo_imagegallery_gallery'
        */
        /*
 		$table = $setup->getConnection()
 		->newTable($setup->getTable('neo_imagegallery_gallery'))
 		->addColumn(
 			'gallery_id',
 			Table::TYPE_INTEGER,
 			11,
 			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
 			'Gallery ID'
 			)
 		->addColumn(
 			'title',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Gallery Title'
 			)
 		->addColumn(
 			'url_key',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Gallery Url Key'
 			)
        ->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Sort Order'
            )
        ->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Status'
            )
        ->setComment('Neo Gallery');
        $setup->getConnection()->createTable($table);
         */
 		/**
 		 * Create table 'neo_gallery_image'
 		 */
 		$table = $setup->getConnection()
 		->newTable($setup->getTable('neo_gallery_image'))
 		->addColumn(
 			'image_id',
 			Table::TYPE_INTEGER,
 			null,
 			['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
 			'Image ID'
 			)
 		->addColumn(
 			'title',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Image Title'
 			)
 		->addColumn(
 			'url',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Image Url'
 			)
 		->addColumn(
 			'image',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Image'
 			)
 		->addColumn(
 			'thumbnail',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Image Thumbnail'
        )
        ->addColumn(
            'image_type',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image Type'
        )
        ->addColumn(
            'image_size',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image Size'
        )
 		->addColumn(
 			'tags',
 			Table::TYPE_TEXT,
 			255,
 			['nullable' => false],
 			'Image Tags'
 			)
        ->addColumn(
            'creation_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [],
            'Image Upload Time'
        )
        ->addColumn(
            'update_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            [],
            'Image Modification Time'
        )
        ->addColumn(
            'status',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Status'
        )
        ->addColumn(
            'sort_order',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => '0'],
            'Sort Order'
        )
        ->addIndex(
            $setup->getIdxName('neo_gallery_image', ['image_id']),
            ['image_id']
        )
        ->setComment('Neo Gallery Table');
        $setup->getConnection()->createTable($table);

 		/**
         * Create table 'neo_gallery_store'
         */
        /*
 		$table = $setup->getConnection()
 		->newTable($setup->getTable('neo_gallery_store'))
 		->addColumn(
 			'image_id',
 			Table::TYPE_INTEGER,
 			null,
 			['unsigned' => true, 'nullable' => false, 'primary' => true],
 			'Brand Id'
 			)
 		->addColumn(
 			'store_id',
 			Table::TYPE_SMALLINT,
 			null,
 			['unsigned' => true, 'nullable' => false, 'primary' => true],
 			'Store Id'
 			)
 		->addIndex(
 			$setup->getIdxName('neo_imagegallery_store', ['store_id']),
 			['store_id']
 			)
 		->addForeignKey(
 			$setup->getFkName('neo_imagegallery_store', 'image_id', 'neo_imagegallery_image', 'image_id'),
 			'image_id',
 			$setup->getTable('neo_imagegallery_image'),
 			'image_id',
 			Table::ACTION_CASCADE
 			)
 		->addForeignKey(
 			$setup->getFkName('neo_imagegallery_store', 'store_id', 'store', 'store_id'),
 			'store_id',
 			$setup->getTable('store'),
 			'store_id',
 			Table::ACTION_CASCADE
 			)
 		->setComment('Neo Image Store');
 		$setup->getConnection()->createTable($table);
        */
 		$setup->endSetup();
 	}
 }
