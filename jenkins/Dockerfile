FROM jenkins/jenkins:lts

USER root

# Install Docker CLI
RUN apt-get update && \
    apt-get install -y docker.io docker-compose && \
    apt-get clean

# Add Jenkins user to docker group
RUN usermod -aG docker jenkins

USER jenkins
