load 'deploy' if respond_to?(:namespace) # cap2 differentiator

require 'capifony_symfony2'

after "deploy:finalize_update" do
  run "chown -R www-data:www-data #{latest_release}/#{cache_path}"
  run "chown -R www-data:www-data #{latest_release}/#{log_path}"
  run "chmod -R 777 #{latest_release}/#{cache_path}"
end

load 'app/config/deploy'