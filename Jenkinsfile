pipeline {
    agent any

    environment {
        DOCKER_BUILDKIT = '1'
        COMPOSE_DOCKER_CLI_BUILD = '1'
    }

    stages {

        stage('Checkout Code') {
            steps {
                git branch: 'main', url: 'https://github.com/Abhiabhi1019/magento-project-local.git'
            }
        }

        stage('Verify Workspace') {
            steps {
                sh '''
                echo "Current Directory:"
                pwd
                echo "Project Files:"
                ls -la
                '''
            }
        }

        stage('Check Docker Installation') {
            steps {
                sh '''
                docker --version
                docker compose version
                '''
            }
        }

        stage('Stop Existing Containers') {
            steps {
                sh '''
                echo "Stopping old containers..."
                docker compose down || true
                '''
            }
        }

        stage('Build Docker Images') {
            steps {
                sh '''
                echo "Building Docker images..."
                docker compose build
                '''
            }
        }

        stage('Start Containers') {
            steps {
                sh '''
                echo "Starting containers..."
                docker compose up -d
                '''
            }
        }

        stage('Verify Running Containers') {
            steps {
                sh '''
                echo "Running containers:"
                docker ps
                '''
            }
        }

    }

    post {
        success {
            echo 'Magento Docker deployment completed successfully!'
        }
        failure {
            echo 'Pipeline failed. Check logs.'
        }
    }
}
