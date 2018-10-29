eval $(ssh-agent)
ssh-add /root/.ssh/id_rsa-roy
git config branch.master.remote origin
git stash
git pull origin +master