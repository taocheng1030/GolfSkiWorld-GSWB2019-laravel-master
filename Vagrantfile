Vagrant.configure("2") do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.provider "virtualbox" do |v|
    v.name = "GolfSkyWorld server"
  end

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
  end

  config.vm.network "private_network", ip: "192.168.10.10"

  config.vm.provision :shell, path: "bootstrap/vagrant/install.sh"
  config.vm.provision :shell, path: "bootstrap/vagrant/deploy.sh"
  config.vm.provision :shell, path: "bootstrap/vagrant/start.sh"
  config.vm.provision :shell, path: "bootstrap/vagrant/nodejs.sh"

end
