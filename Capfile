role :libs, "vagrant@192.168.100.22", "vagrant@192.168.100.23", "vagrant@192.168.100.24"

task :start_daemon, :roles => :libs do
  run "cd code && php daemon.php &&"
end

task :view_log, :roles => :libs do
  run "cd code && tail -f 5 log"
end