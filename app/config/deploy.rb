set :application, "commander"
set :domain,      "192.168.1.48"
set :deploy_to,   "/var/www/#{application}"
set :app_path,    "app"
set :user, "root"

set :repository,  "git@github.com:etokas/train-commander.git"
set :scm,         :git

set :model_manager, "doctrine"
# Or: `propel`

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain, :primary => true       # This may be the same as your `Web` server

set  :keep_releases,  3
set  :use_sudo,      false

ssh_options[:forward_agent] = true

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/cache", app_path + "/logs", web_path + "/uploads", "vendor"]

set :writable_dirs, ["app/cache", "app/logs"]
set :permission_method, :acl
default_run_options[:pty] = true
#set :update_vendors, true

# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL