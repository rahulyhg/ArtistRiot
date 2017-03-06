<?php 

use Doctrine\Common\ClassLoader,
Doctrine\ORM\Configuration,
Doctrine\ORM\EntityManager,
Doctrine\Common\Cache\ArrayCache,
Doctrine\DBAL\Logging\EchoSQLLogger,
Doctrine\ORM\Mapping\Driver\DatabaseDriver,
Doctrine\ORM\Tools\DisconnectedClassMetadataFactory,
Doctrine\ORM\Tools\EntityGenerator,
Doctrine\ORM\Tools\Setup;

class Doctrine
{
    // the Doctrine entity manager
    public $em;

    public function __construct()
    {
    	//require __DIR__ . '/Doctrine/ORM/Tools/Setup.php';
    	//Setup::registerAutoloadDirectory(__DIR__);
        
        // include our CodeIgniter application's database configuration
        require APPPATH.'config/database.php';
        
        // include Doctrine's fancy ClassLoader class
        require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';
        
        // load the Doctrine classes
        $doctrineClassLoader = new \Doctrine\Common\ClassLoader('Doctrine', APPPATH.'libraries');
        $doctrineClassLoader->register();
        
        // load Symfony2 helpers
        // Don't be alarmed, this is necessary for YAML mapping files
        $symfonyClassLoader = new \Doctrine\Common\ClassLoader('Symfony', APPPATH.'libraries/Doctrine');
        $symfonyClassLoader->register();

        // load the entities
        $entityClassLoader = new \Doctrine\Common\ClassLoader('Entities', APPPATH.'models');
        $entityClassLoader->register();

        // load the proxy entities
        $proxyClassLoader = new \Doctrine\Common\ClassLoader('Proxies', APPPATH.'models');
        $proxyClassLoader->register();

        // set up the configuration 
        $config = new \Doctrine\ORM\Configuration;
    
        if(ENVIRONMENT == 'development')
            // set up simple array caching for development mode
            $cache = new \Doctrine\Common\Cache\ArrayCache;
        else
            // set up caching with APC for production mode
        $cache = new \Doctrine\Common\Cache\ApcCache;
        
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);

        // set up proxy configuration
        $config->setProxyDir(APPPATH.'models/Proxies');
        $config->setProxyNamespace('Proxies');
        
        // auto-generate proxy classes if we are in development mode
        $config->setAutoGenerateProxyClasses(ENVIRONMENT == 'development');

        // set up annotation driver
        $yamlDriver = new \Doctrine\ORM\Mapping\Driver\YamlDriver(APPPATH.'models/Mappings');
        $config->setMetadataDriverImpl($yamlDriver);


        // Database connection information
        $connection_options = array(
            'driver' => 'pdo_mysql',
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database']
        );
        
        // create the EntityManager
        //$config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode = false, $proxies_dir);
       $em = \Doctrine\ORM\EntityManager::create($connection_options, $config);
       //$em = EntityManager::create($connection_options, $config);
        // store it as a member, for use in our CodeIgniter controllers.
        $this->em = $em;
        
        //$loader = new ClassLoader($models_namespace, $models_path);
        //$loader->register();
        
       // $this->generate_classes();
    }
    
    function generate_classes(){
    	 
    	$this->em->getConfiguration()->setMetadataDriverImpl(new DatabaseDriver($this->em->getConnection()->getSchemaManager()));
    
    	$cmf = new DisconnectedClassMetadataFactory();
    	$cmf->setEntityManager($this->em);
    	$metadata = $cmf->getAllMetadata();
    	$generator = new EntityGenerator();
    	 
    	$generator->setUpdateEntityIfExists(true);
    	$generator->setGenerateStubMethods(true);
    	$generator->setGenerateAnnotations(true);
    	$generator->generate($metadata, APPPATH."models/Proxies");
    	 
    	$cme = new \Doctrine\ORM\Tools\Export\ClassMetadataExporter();
    	$exporter = $cme->getExporter('yml', APPPATH."models/Mappings");
    	$exporter->setMetadata($metadata);
    	$exporter->export();
    	
    }
    
    
}