<?php

use Doctrine\Common\ClassLoader,
Doctrine\ORM\Configuration,
Doctrine\ORM\EntityManager,
Doctrine\Common\Cache\ArrayCache,
Doctrine\Common\Cache\MemcachedCache,
Doctrine\DBAL\Logging\EchoSQLLogger,
Doctrine\ORM\Mapping\Driver\DatabaseDriver,
Doctrine\ORM\Tools\DisconnectedClassMetadataFactory,
Doctrine\ORM\Tools\EntityGenerator,
Doctrine\ORM\Tools\Setup;

class Doctrine {

  public $em = null;

  public function __construct()
  {
    // load database configuration from CodeIgniter
    require APPPATH.'config/database.php';

    // Set up class loading. You could use different autoloaders, provided by your favorite framework,
    // if you want to.
    require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';

    $doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH.'libraries');
    $doctrineClassLoader->register();
    $entitiesClassLoader = new ClassLoader('Entities', APPPATH.'models/Entities');
    $entitiesClassLoader->register();
    $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/Proxies');
    $proxiesClassLoader->register();
    $symfonyClassLoader = new ClassLoader('Symfony', APPPATH.'libraries/Doctrine');
    $symfonyClassLoader->register();

    // Set up caches
    $config = new Configuration();
    $cache = new ArrayCache;
    $config->setMetadataCacheImpl($cache);
    $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/Entities'),  $dev_mode = true);
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cache);
    $config->setResultCacheImpl($cache);
    
    /***** Memcache settings ****
    $memcache = new Memcache();
    $memcache->connect('localhost', 11211);
   	$cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
   	$cacheDriver->setMemcache($memcache);
   	$cacheDriver->save('cache_id', 'my_data');
   	
   	**/
    
   /*  $redis = new Redis();
    $redis->connect('localhost', 6379);
    
    $cacheDriver = new \Doctrine\Common\Cache\RedisCache();
    $cacheDriver->setRedis($redis);
    $cacheDriver->save('cache_id', 'my_data');
    
    $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/Entities'),  $dev_mode = true);
    $config->setMetadataDriverImpl($driverImpl);
    $config->setQueryCacheImpl($cacheDriver);
    $config->setResultCacheImpl($cacheDriver); */

    // Proxy configuration
    $config->setProxyDir(APPPATH.'/models/Proxies');
    $config->setProxyNamespace('Proxies');
	$config->setAutoGenerateProxyClasses(true);
    

    // Database connection information
    $connectionOptions = array(
        'driver' => 'pdo_mysql',
        'user' =>     $db['default']['username'],
        'password' => $db['default']['password'],
        'host' =>     $db['default']['hostname'],
        'dbname' =>   $db['default']['database']
    );

    // Create EntityManager
   
    $this->em = EntityManager::create($connectionOptions, $config);
    $this->em->getConfiguration()->setMetadataDriverImpl(new DatabaseDriver($this->em->getConnection()->getSchemaManager()));
  	//$this->generate_classes();
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
  	$generator->generate($metadata, APPPATH."models/Entities");
  	
  /*	$cme = new \Doctrine\ORM\Tools\Export\ClassMetadataExporter();
  	$exporter = $cme->getExporter('yml', APPPATH."models/Mappings");
  	$exporter->setMetadata($metadata);
  	$exporter->export(); */
  
  }
}