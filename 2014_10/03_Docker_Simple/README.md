#[fit] DOCKER

---

# 김예솔

NAVER Labs
XpressEngine PM
NAVER D2
XECon + PHPFest 2014 준비중... 11/8

---

# Docker is ...

An open platform for developers and sysadmins to build, ship, and run distributed applications.

---

# History

- Solomon Hykes
- Internal Project within dotCloud 2013.01
- 2013.03 Released by OSS
- Python -> Go
- Vmware, RedHat 지원중
- TravisCI

---

# 구성
- **L**inu**X** **C**ontainers (Kernel 2.6.24)
  - Isolation with Control Groups
     	pid, network, ipc, mnt, hostname, user
  - Isolation with Namespaces
    	memory, cpu, device

---

# 구성
- Union File System
  - AUFS (Advanced multi layered unification filesystem)
  - bootfs(bootloader, kernel), rootfs, writeable fs

---

# VM vs Docker
- Vagrant vs Docker
- VargrantFile vs DockerFile
- Docker Image
    - Public Repo [https://registry.hub.docker.com](https://registry.hub.docker.com)
- Vm vs Container
- Guest OSs vs Isolated

[https://www.docker.com/whatisdocker](https://www.docker.com/whatisdocker/)

---

# Container

booting 과정이 없다.
Supervisord 와 같은 Process Manager 필요
Native Performace(CPU, Memory, Disk, Network)
Share bins/libraries

---

# Demo

---

# VM 처럼 사용해야하나?

---

# Production

- HAProxy
- Memcached
- Apache/Nginx
- PHP-FPM
- HHVM

---

#[fit] [http://demo.xpressengine.com](http://demo.xpressengine.com)

---

# IF ...

---

#[fit] CoreOS

---

![inline](https://coreos.com/assets/images/media/Host-Diagram.png)

---

![inline](https://coreos.com/assets/images/media/Fleet-Scheduling.png)

---

