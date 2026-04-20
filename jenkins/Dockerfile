FROM jenkins/jenkins:lts

USER root

# Install system dependencies
RUN apt-get update && apt-get install -y \
    ca-certificates \
    curl \
    gnupg \
    lsb-release \
    && rm -rf /var/lib/apt/lists/*

# Add Docker's official GPG key
RUN curl -fsSL https://download.docker.com/linux/debian/gpg \
    | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Set up the stable Docker repository
RUN echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] \
  https://download.docker.com/linux/debian $(lsb_release -cs) stable" \
  | tee /etc/apt/sources.list.d/docker.list > /dev/null

# Install Docker CLI and Compose V2 Plugin
RUN apt-get update && apt-get install -y \
    docker-ce-cli \
    docker-compose-plugin \
    && rm -rf /var/lib/apt/lists/*

# ── Dynamic Docker GID fix ─────────────────────────────────────────────────
# Accept the host docker group GID as a build argument (default 984).
# This ensures the jenkins user inside the container can access /var/run/docker.sock
# without hard-coding a GID that may differ on different hosts.
ARG DOCKER_GID=984
RUN groupadd -g ${DOCKER_GID} -o docker 2>/dev/null || groupmod -g ${DOCKER_GID} docker && \
    usermod -aG docker jenkins

USER jenkins

WORKDIR /var/jenkins_home
