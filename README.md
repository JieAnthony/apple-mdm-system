# Apple MDM System

## 关于项目
这是一个基于laravel和filament开发的苹果移动设备管理系统，使用此系统可以快速接入苹果的MDM服务。

## 功能亮点
- 激活锁
- 丢失模式
- 功能限制策略
- 发送自定义指令
- 获取设备已安装的应用程序

## 先决条件
- 拥有[Apple Business Manager](https://business.apple.com/)账号并审核通过
- 拥有[Apple Developer](https://developer.apple.com)账号并且加入Apple Developer Program

## 代码环境要求
- php >= 8.2
- mysql

## 项目依赖
- [micromdm/nanodep](https://github.com/micromdm/nanodep)
- [micromdm/nanomdm](https://github.com/micromdm/nanomdm)
- [micromdm/scep](https://github.com/micromdm/scep)

## 功能展示

![1](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911059-acfef2c0-c1ca-4f97-8cf1-ab632d5623c9.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083858Z&X-Amz-Expires=300&X-Amz-Signature=bf5a989332f6031f760cfc63baeb218636bf02f741352f6bc5a558376cf4a020&X-Amz-SignedHeaders=host)
![2](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911054-cef6c570-361d-49f6-831f-7a78b9957d69.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083838Z&X-Amz-Expires=300&X-Amz-Signature=88948ea4f202818f5e765ee85d532cdf5afbd1b0cf1c6071f227558f879ad946&X-Amz-SignedHeaders=host)
![3](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911053-22bbb967-8dfb-427e-a7f0-eb3e6983fabd.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083909Z&X-Amz-Expires=300&X-Amz-Signature=a79167c22b4058fbade70dcbbd483be350eae6532274c21925ffd26a0108ae44&X-Amz-SignedHeaders=host)
![4](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911057-8d226ada-6334-48b0-abd4-85174cb95a61.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083921Z&X-Amz-Expires=300&X-Amz-Signature=d9ed64c578ddaecf52bbbbeedb4080c9ee246745970c03c6280dedbecf04bde5&X-Amz-SignedHeaders=host)
![5](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911056-16d295ef-03e9-4e7c-8ca7-14c588d1f502.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083936Z&X-Amz-Expires=300&X-Amz-Signature=c989d33b39135234de6146744b7c705af6b17b483edf4fb17ff110ae23c227fd&X-Amz-SignedHeaders=host)
![6](https://github-production-user-asset-6210df.s3.amazonaws.com/38497992/501911055-717e4ae9-1e31-48a4-ab79-dfcca1f22881.png?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVCODYLSA53PQK4ZA%2F20251016%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20251016T083946Z&X-Amz-Expires=300&X-Amz-Signature=92b26ef0d3e3e22e250f06eb57fb68afd4bc7234eafadc67ec24280375cbfba0&X-Amz-SignedHeaders=host)

## 安装

> tips:请将项目依赖里的每一个服务进行部署后再走下面的流程

```shell
git clone https://github.com/JieAnthony/apple-mdm-system.git
cp .env.example .env
```

```dotenv
# DEP配置
DEP_HOST=#配置DEP服务地址
DEP_USERNAME=#配置DEP接口请求用户名
DEP_PASSWORD=#配置DEP接口请求密码
DEP_NAME=#配置DEP服务名称，即ABM创建的MDM服务器名称
DEP_PROFILE_UUID=#使用 php artisan dep:create-profile 进行创建并回填到这里

# MDM配置
MDM_HOST=#配置MDM服务地址,可以是内网地址
MDM_ENROLLMENT_HOST=#配置MDM服务地址,必须是公网带域名的SSL地址
MDM_USERNAME=#配置MDM接口请求用户名
MDM_PASSWORD=#配置MDM接口请求密码
MDM_BUNDLE_ID=#com.dev.ams 自行配置

# SCEP配置
SCEP_ENROLLMENT_HOST=#配置SCEP服务地址,必须是公网带域名的SSL地址
SCEP_CHALLENGE=#启动SCEP服务的参数，回调到这里

APPLE_APNS_TOPIC=#推送证书的topic
APPLE_ORG_NAME=#公司名称
APPLE_GUID=#负责人邮箱
```
将其他配置填写后，运行以下命令进行初始化
```shell
composer install

php artisan key:generate

# 执行迁移
php artisan migrate

# 填充数据
php artisan db:seed --class=FunctionalRestrictionSeeder

# 初始化管理员
php artisan make:filament-user
```

浏览器访问 域名/admin 进行登录

## License
[MIT license](https://opensource.org/licenses/MIT).
