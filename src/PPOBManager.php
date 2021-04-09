<?php

namespace Rick20\PPOB;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Manager;

class PPOBManager extends Manager
{
    protected $client;

    public function __construct($app, ClientInterface $client = null)
    {
        parent::__construct($app);

        $this->client = $client ?? $this->getDefaultClient();
    }

    public function account($name)
    {
        return $this->driver($name);
    }

    protected function createMobilePulsaDriver(array $config)
    {
        return new Providers\MobilePulsa(
            $config['username'], $config['apikey'], $this->container->environment('production'), $this->client
        );
    }

    protected function createPortalPulsaDriver(array $config)
    {
        return new Providers\PortalPulsa(
            $config['userid'], $config['key'], $config['secret'], $this->client
        );
    }

    protected function createTripayDriver(array $config)
    {
        return new Providers\Tripay(
            $config['apikey'], $config['pin'], $this->client
        );
    }

    protected function createIndoH2HDriver(array $config)
    {
        return new Providers\IndoH2H(
            $config['username'], $config['apikey'], $this->client
        );
    }
    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['ppob.default'];
    }

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        $driver = $driver ?: $this->getDefaultDriver();

        // If the given driver has not been created before, we will create the instances
        // here and cache it so we can return it next time very quickly. If there is
        // already a driver created by this name, we'll just return that instance.
        if (! isset($this->drivers[$driver])) {
            $this->drivers[$driver] = $this->createDriver($driver);
        }

        return $this->drivers[$driver];
    }

    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    protected function createDriver($driver, $config = [])
    {
        // We'll check to see if a creator method exists for the given driver. If not we
        // will check for a custom driver creator, which allows developers to create
        // drivers using their own customized driver creator Closure to create it.
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        } else {
    
            $config = $this->container['config']['ppob.accounts.' . $driver];

            $method = 'create'.Str::studly($config['provider']).'Driver';

            if (method_exists($this, $method)) {
                return $this->$method(Arr::except($config, ['provider']));
            }
        }
        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    protected function getDefaultClient()
    {
        try {
            return app(ClientInterface::class);
        } catch (\ReflectionException $error) {
            return new Client();
        }
    }
}
