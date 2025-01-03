require('dotenv').config();
const echo = require('laravel-echo-server');
const env = {...process.env};

Object.entries(env).forEach(([key, value]) => {
    if (value === 'true') env[key] = true;
    if (value === 'false') env[key] = false;
    if (value === 'null') env[key] = null;
    if (!isNaN(Number(value))) env[key] = Number(value);
});

const replaceAll = (str, search, replace) => str.split(search).join(replace);
const getRedisPrefix = () => {
    const appName = env.APP_NAME || 'laravel';
    const redisPrefix = env.REDIS_PREFIX;

    return redisPrefix || replaceAll(`${appName}_database_`, ' ', '_');
};

const authHost = [env.PROTOCOL, '://', env.BACKOFFICE_API_SUBDOMAIN, '.' ,env.DOMAIN].join('');

echo.run({
    authHost: authHost,
    authEndpoint: '/broadcasting/auth',
    clients: [],
    database: 'redis',
    databaseConfig: {
        redis: {
            // keyPrefix: "laravel_database_",
            keyPrefix: getRedisPrefix(),
            host: env.REDIS_HOST || '127.0.0.1',
            port: env.REDIS_PORT || 6379,
            // password: env.REDIS_PASSWORD,
        },
        sqlite: {
            'databasePath': '/database/laravel-echo-server.sqlite',
        },
    },
    devMode: env.ECHO_DEBUG,
    host: env.ECHO_HOST || 'localhost',
    port: env.ECHO_PORT || 6000,
    protocol: env.ECHO_PROTOCOL || 'http',
    socketio: {},
    sslCertPath: '',
    sslKeyPath: '',
    sslCertChainPath: '',
    sslPassphrase: '',
    subscribers: {
        http: true,
        redis: true,
    },
    apiOriginAllow: {
        allowCors: true,
        allowOrigin: '*',
        allowMethods: 'GET, POST',
        allowHeaders: 'Origin, Content-Type, X-Auth-Token, X-Requested-With, Accept, Authorization, X-CSRF-TOKEN, X-Socket-Id',
    },
});
