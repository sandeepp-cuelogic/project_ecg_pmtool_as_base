#!/bin/bash --login

cd /home/cuelogic/rails_project/demo_hrms 
rvm gemset use 2.1.5@jenkins
bundle exec rake spec